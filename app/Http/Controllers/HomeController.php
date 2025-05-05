<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Catalog;

class HomeController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->latest()->take(5)->get(); // ambil review + user-nya
        $testimonials = [
            ['name' => 'Budi Santoso', 'text' => 'Pelayanan cepat dan ramah!'],
            ['name' => 'Siti Aminah', 'text' => 'Barangku jadi seperti baru, keren banget!'],
        ];

        return view('home', compact('reviews', 'testimonials'));
    }
    public function KomputerCatalog()
    {
        return view('komputer');
    }
    public function LaptopCatalog()
    {
        return view('laptop');
    }
    public function perlengkapanCatalog(Request $request)
    {
        $query = Catalog::query();
        $query->where('kategori', 'perlengkapan');
        $perlengkapan = $query->get(); 
        return view('perlengkapan', compact('perlengkapan'));
    }
    
    public function perlengkapanLaptop(Request $request)
    {
        $query = Catalog::query();
        $query->where('kategori', 'laptop');
        $laptop = $query->get(); 
        return view('akse-laptop', compact('laptop'));
    }
    
    

}
