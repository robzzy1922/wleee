<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.customer')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('order.customer')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'Lunas';
        $payment->save();
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'Ditolak';
        $payment->save();
        return back()->with('error', 'Pembayaran ditolak.');
    }

    public function destroy($id)
{
    // Logika untuk menghapus data pembayaran
    Pembayaran::find($id)->delete();
    return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
}

public function export()
{
    // Logika untuk export data pembayaran (misalnya ke CSV atau Excel)
    // Bisa menggunakan paket seperti Maatwebsite Excel
    return Excel::download(new PembayaranExport, 'pembayaran.xlsx');
}
}
