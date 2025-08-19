<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusMail;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Str;   // 👈 Bunu ekle
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function storePublic(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'datetime' => 'required|date_format:Y-m-d H:i',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
            'duration' => 'nullable|integer|min:15|max:240',
            'is_preorder' => 'nullable|boolean'
        ]);

        $start = $request->datetime;
        $end = \Carbon\Carbon::parse($start)->addMinutes($request->duration ?? 90);

        $reservation = Reservation::create([
            'table_id' => $request->table_id,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'datetime' => $start,
            'end_datetime' => $end,
            'people' => $request->people,
            'message' => $request->message,
            'status' => 'reserved',
            'is_preorder' => $request->has('is_preorder'),
            'total_price' => 0,
            'payment_status' => 'unpaid',
            'preorder_token' => Str::random(32), // random token
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rezervasyon başarıyla oluşturuldu.',
            'preorder_url' => route('reservation.preorder', $reservation->preorder_token)
        ]);

    }



    public function reject($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'rejected';
        $reservation->save();

        // Müşteriye mail gönder
        Mail::to($reservation->email)->send(new ReservationStatusMail($reservation));

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon reddedildi ve müşteriye mail gönderildi.');
    }










    public function index(Request $request)
    {
        $query = Reservation::query();

        if ($request->filled('table_id')) {
            $query->where('table_id', $request->input('table_id'));
        }

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                    ->orWhere('surname', 'like', "%{$name}%");
            });
        }

        $start = $request->input('datetime_start');
        $end = $request->input('datetime_end');

        if ($start && $end) {
            $startDate = Carbon::parse($start)->format('Y-m-d H:i:s');
            $endDate = Carbon::parse($end)->format('Y-m-d H:i:s');

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('datetime', [$startDate, $endDate])
                    ->orWhereBetween('end_datetime', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('datetime', '<=', $startDate)
                            ->where('end_datetime', '>=', $endDate);
                    });
            });
        } elseif ($start) {
            $startDate = Carbon::parse($start)->format('Y-m-d H:i:s');
            $query->where('datetime', '>=', $startDate);
        } elseif ($end) {
            $endDate = Carbon::parse($end)->format('Y-m-d H:i:s');
            $query->where('end_datetime', '<=', $endDate);
        }

        $reservations = $query->orderBy('datetime', 'asc')->paginate(10)->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }



    // Yeni rezervasyon ekleme
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'datetime' => 'required|date_format:Y-m-d H:i',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
            'duration' => 'nullable|integer|min:15|max:240',
            'is_preorder' => 'nullable|boolean'
        ]);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->datetime);
        $duration = (int) $request->input('duration', 90);
        $end = $start->copy()->addMinutes($duration);

        // Çalışma saatleri kontrolü (aynı şekilde)
        $day = $start->dayOfWeek;
        $time = $start->format('H:i');

        if ($day === 0) {
            if ($time < '10:00' || $time > '20:00') {
                return back()->withErrors(['datetime' => 'Pazar günleri rezervasyonlar 10:00 - 20:00 saatleri arasında yapılabilir.'])->withInput();
            }
        } else {
            if ($time < '09:00' || $time > '21:00') {
                return back()->withErrors(['datetime' => 'Rezervasyonlar 09:00 - 21:00 saatleri arasında yapılabilir.'])->withInput();
            }
        }

        // Çakışma kontrolü
        $conflict = Reservation::where('table_id', $request->table_id)
            ->whereIn('status', ['reserved', 'approved'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('datetime', '<', $end)
                        ->where('end_datetime', '>', $start);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['table_id' => 'Seçilen masa bu zaman aralığında doludur!'])->withInput();
        }

        try {
            $reservation = Reservation::create([
                'table_id' => $request->table_id,
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'datetime' => $start,
                'end_datetime' => $end,
                'people' => $request->people,
                'message' => $request->message,
                'status' => 'reserved',
                'is_preorder' => $request->has('is_preorder'),
                'total_price' => 0,
                'payment_status' => 'unpaid',
            ]);

// Eğer ön sipariş seçilmişse, preorder sayfasına yönlendir
            if ($request->ajax()) {
                $response = ['success' => true, 'message' => 'Rezervasyon başarıyla gönderildi.'];

                // Eğer ön sipariş seçilmişse, JS’e yönlendirme URL’si gönder
                if($reservation->is_preorder){

                    $response['preorder_url'] = route('reservation.preorder', $reservation->preorder_token);

                }

                return response()->json($response);
            }

            // Değilse redirect
            return back()->with('success', 'Rezervasyon başarıyla gönderildi.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Rezervasyon gönderilirken hata oluştu.']);
            }
            return back()->with('error', 'Rezervasyon gönderilirken hata oluştu.');
        }
    }



    // Rezervasyonu onaylama
    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'approved';
        $reservation->save();

        Mail::to($reservation->email)->send(new ReservationStatusMail($reservation));


        return redirect()->route('reservations.index')->with('success', 'Rezervasyon onaylandı ve müsteriye mail gönderildi.');
    }

    // Rezervasyonu silme
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        Mail::to($reservation->email)->send(new ReservationStatusMail($reservation));

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon silindi ve  müsteriye mail gönderildi.');
    }

    // AJAX: Tarih ve süreye göre masa uygunluk durumu (boş/dolu)
    public function tablesAvailability(Request $request)
    {
        $datetime = $request->query('datetime');
        $duration = (int) $request->query('duration', 90); // kesin int cast

        if (!$datetime) {
            return response()->json(['error' => 'Datetime parameter required'], 400);
        }

        $start = Carbon::parse($datetime);
        $end = $start->copy()->addMinutes($duration);

        // Tüm masalar
        $tables = Table::orderBy('name')->get();

        // Çakışan rezervasyonlar (zaman aralığı örtüşenler)
        $conflictingReservations = Reservation::whereIn('status', ['reserved', 'approved'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('datetime', '<', $end)
                        ->where('end_datetime', '>', $start);
                });
            })
            ->pluck('table_id')
            ->toArray();

        $available = [];
        $booked = [];

        foreach ($tables as $table) {
            if (in_array($table->id, $conflictingReservations)) {
                $booked[] = ['id' => $table->id, 'name' => $table->name];
            } else {
                $available[] = ['id' => $table->id, 'name' => $table->name];
            }
        }

        return response()->json([
            'available' => $available,
            'booked' => $booked,
        ]);
    }



    public function analytics()
    {
        // Son 30 gün içinde günlük rezervasyon sayıları
        $dailyReservations = Reservation::select(
            DB::raw('DATE(datetime) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('datetime', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Son 12 ay içinde aylık rezervasyon sayıları
        $monthlyReservations = Reservation::select(
            DB::raw('DATE_FORMAT(datetime, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('datetime', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();




        // Verileri Blade'e gönderiyoruz
        return view('admin.analytics.index', compact('dailyReservations', 'monthlyReservations'));

    }


    public function showReservationForm()
    {
        $menus = Menu::where('active', 1)->get();

        return view('reservation.form', compact('menus'));
    }



    public function preorder($token)
    {
        $reservation = Reservation::where('preorder_token', $token)->firstOrFail();
        $menus = Menu::where('active', true)->get();
        $cart = session('cart_'.$reservation->id, []);

        return view('reservation.preorder', compact('reservation', 'menus', 'cart'));
    }


    public function getCart($reservationToken)
    {
        $reservation = Reservation::where('preorder_token', $reservationToken)->firstOrFail();
        $cart = $reservation->cart()->with('items')->first();

        if (!$cart) {
            return response()->json(['items' => [], 'total' => 0]);
        }

        $items = $cart->items->map(function($i){
            return [
                'id' => (string)$i->menu_id, // frontend id string kullanıyor
                'name' => optional($i->menu)->name,
                'price' => (float)$i->price,
                'quantity' => (int)$i->quantity,
                'total_price' => (float)$i->total_price,
            ];
        });

        $total = $cart->items->sum('total_price');

        return response()->json(['items' => $items, 'total' => (float)$total]);
    }



    // Sepete ürün ekleme
    public function updateCart(Request $request, $reservationToken)
    {
        $reservation = Reservation::where('preorder_token', $reservationToken)->firstOrFail();
        $dataCart = $request->input('cart', []); // [{id,name,price,quantity}...]

        // cart yoksa oluştur
        $cart = $reservation->cart()->first();
        if (!$cart) {
            $cart = $reservation->cart()->create();
        }

        // mevcut item’ları önce indexleyelim
        $existing = $cart->items()->get()->keyBy('menu_id');

        // geleni işle
        $incomingIds = collect($dataCart)->pluck('id')->map(fn($v)=>(int)$v)->all();

        // silinenleri temizle
        $cart->items()->whereNotIn('menu_id', $incomingIds)->delete();

        foreach ($dataCart as $row) {
            $menuId = (int)$row['id'];
            $qty = max(1, (int)$row['quantity']);
            $price = (float)$row['price'];
            $total = $price * $qty;

            if ($existing->has($menuId)) {
                $existing[$menuId]->update([
                    'quantity' => $qty,
                    'price' => $price,
                    'total_price' => $total,
                ]);
            } else {
                $cart->items()->create([
                    'menu_id' => $menuId,
                    'quantity' => $qty,
                    'price' => $price,
                    'total_price' => $total,
                ]);
            }
        }

        $sum = $cart->items()->sum('total_price');
        return response()->json(['message' => 'Sepet güncellendi', 'total' => (float)$sum]);
    }


    public function emptyCart(Request $request, $reservationToken)
    {
        $reservation = Reservation::where('preorder_token', $reservationToken)->firstOrFail();
        $cart = $reservation->cart;

        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        return response()->json(['message' => 'Sepet temizlendi']);
    }


// Sepetten ürün çıkar
    public function finalizePreorder(Request $request, $reservationToken)
    {
        $reservation = Reservation::where('preorder_token', $reservationToken)->firstOrFail();

        // DB’deki cart üzerinden ilerleyelim (frontend’dekini güvenlik için referans almayalım)
        $cart = $reservation->cart()->with('items')->first();

        // Eğer istersen, frontend’ten gelen cart ile son senkronu yap:
        $incoming = $request->input('cart', []);
        if ($incoming) {
            // küçük bir reuse
            $this->updateCart(new Request(['cart' => $incoming]), $reservationToken);
            $cart = $reservation->cart()->with('items')->first();
        }

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Sepet boş!'], 400);
        }

        $totalPrice = $cart->items->sum('total_price');

        $order = $reservation->orders()->create([
            'total_price' => $totalPrice,
            'payment_status' => 'unpaid',
        ]);

        foreach ($cart->items as $ci) {
            $order->orderItems()->create([
                'menu_id' => $ci->menu_id,
                'quantity' => $ci->quantity,
                'price' => $ci->price,
                'total_price' => $ci->total_price,
            ]);
        }

        // cart’ı temizle
        $cart->items()->delete();
        $cart->delete();

        return response()->json([
            'message' => 'Ön sipariş başarıyla kaydedildi.',
            'redirect_url' => route('payment.page', ['order' => $order->id]),
        ]);
    }










    public function checkout($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        return view('reservation.checkout', compact('reservation'));
    }







// Sayfa kapatıldığında tokeni sil
    public function abandonCart(Request $request, Reservation $reservation): \Illuminate\Http\JsonResponse
    {


        Log::info('SAA');


        $reservation->preorder_token = null;  // Her durumda sil
        $reservation->save();

        return response()->json(['message' => 'Token silindi.']);
    }

// Kullanıcı rezervasyon ID ile yeni token almak istediğinde
    public function generateNewToken(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['reservation_id' => 'required|exists:reservations,id']);

        $reservation = Reservation::findOrFail($request->reservation_id);
        $newToken = Str::random(32);
        $reservation->preorder_token = $newToken;
        $reservation->save();

        // Mail gönder
        Mail::to($reservation->email)->send(new ReservationStatusMail($reservation));

        return response()->json([
            'message' => 'Yeni token oluşturuldu ve mail gönderildi.',
            'new_token' => $newToken
        ]);
    }






}
