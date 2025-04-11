<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = [
            ['question' => 'Harga Service nya sesuai dengan harga tertera?', 'answer' => 'Ya, harga sesuai dengan yang tertera di website.'],
            ['question' => 'Berapa lama waktu pengecekan?', 'answer' => 'Pengecekan biasanya 1 - 3 hari setelah penjemputan barang.'],
            ['question' => 'Gawai Kita Menerima Service apa saja?', 'answer' => 'Kami menerima service Laptop, komputer, dan printer baik hardware maupun software.'],
            ['question' => 'Proses service bisa satu hari?', 'answer' => 'Durasi perbaikan tergantung tingkat kerusakan. Akan diinformasikan saat pengecekan.'],
            ['question' => 'Bisa Service langsung ke tempatnya?', 'answer' => 'Bisa, toko TechFix ada di Jaya Plaza, gedung Jayaplaza Blok R1.'],
            ['question' => 'Perangkat kita aman dibawa oleh kurir?', 'answer' => 'Aman, karena kurir kami menggunakan form khusus sebelum membawa perangkat.']
        ];

        return view('faq', compact('faqs'));
    }
}
