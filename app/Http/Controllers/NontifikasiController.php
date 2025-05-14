<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class NotifikasiController extends Controller
{
    public function read(Request $request)
{
    $pesanan = Pesanan::find($request->id);
    if ($pesanan && $pesanan->user_id === auth()->id()) {
        $pesanan->is_read_customer = true;
        $pesanan->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 403);
}
}
