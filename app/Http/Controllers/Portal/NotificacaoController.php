<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('portal.notificacoes.index', compact('notifications'));
    }

    public function ler(Request $request, string $notification)
    {
        $notif = Auth::user()->notifications()->findOrFail($notification);
        $notif->markAsRead();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        $url = data_get($notif->data, 'url', '/');

        return redirect($url);
    }

    public function naoLidas()
    {
        $total = Auth::user()->notifications()->whereNull('read_at')->count();

        return response()->json(['total' => $total]);
    }

    public function lerTodas()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->route('notificacoes')
            ->with('success', 'Todas as notificações foram marcadas como lidas.');
    }
}
