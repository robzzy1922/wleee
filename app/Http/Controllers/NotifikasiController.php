<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Notification;

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

    public function markAsRead($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->is_read = true;
        $notif->save();

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return back();
    }
}
