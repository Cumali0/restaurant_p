<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index()
    {
        $menus = Menu::where('active', 1)->get();

        return view('index', compact('menus')); // resources/views/index.blade.php dosyasına gönderiyoruz
    }


}
