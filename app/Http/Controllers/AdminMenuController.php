<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->get('mode', 'index'); // index, create, edit
        $menus = null;
        $menu = null;

        // Tüm benzersiz kategorileri çekiyoruz (boş olanları filtreleyerek)
        $categories = Menu::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category');

        if ($mode === 'index') {
            $query = Menu::orderBy('created_at', 'desc');

            // Kategori filtresi uygulanırsa
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            $menus = $query->paginate(10)->withQueryString();
        } elseif ($mode === 'edit') {
            $id = $request->get('menu');
            if (!$id) {
                return redirect()->route('admin.menus.index');
            }
            $menu = Menu::findOrFail($id);
        }
        // create modda menu gerekmez

        return view('admin.menus.index', compact('mode', 'menus', 'menu', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'active' => 'sometimes|accepted',
        ]);

        $data = $request->only('name', 'description', 'price', 'category', 'active');
        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu_images', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Yemek başarıyla eklendi.');
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'active' => 'sometimes|accepted',
        ]);

        $data = $request->only('name', 'description', 'price', 'category', 'active');
        $data['active'] = $request->has('active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menu_images', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Yemek başarıyla güncellendi.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Yemek başarıyla silindi.');
    }
}
