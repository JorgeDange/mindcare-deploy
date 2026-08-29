@extends('layouts.portal')

@section('title', 'Notificações — MindCare')

@section('content')
@php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp

<div class="bg-surface-container-lowest rounded-xl shadow-[0px_2px_8px_rgba(0,0,0,0.04)] border border-outline-variant/30">
    <div class="px-5 py-4 border-b border-outline-variant/30 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-title-lg text-on-surface">Todas as Notificações</span>
            @if($unreadCount > 0)
                <span class="bg-primary text-on-primary text-label-md px-2.5 py-0.5 rounded-full">{{ $unreadCount }} não lida{{ $unreadCount !== 1 ? 's' : '' }}</span>
            @endif
        </div>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('portal.notificacoes.ler-todas') }}" class="m-0">
                @csrf
                <button type="submit" class="bg-transparent border-none text-primary font-medium cursor-pointer text-body-sm font-family-inherit hover:underline">
                    Marcar todas como lidas
                </button>
            </form>
        @endif
    </div>

    @if($notifications->count() === 0)
        <div class="py-16 text-center text-on-surface-variant">
            <i class="fa-regular fa-bell-slash text-4xl mb-3 block text-outline-variant"></i>
            <p class="text-body-sm">Nenhuma notificação encontrada.</p>
        </div>
    @else
        <div class="divide-y divide-outline-variant/20">
            @foreach($notifications as $notif)
                @php
                    $data = $notif->data;
                    $icone = $data['icone'] ?? 'bell';
                    $titulo = $data['titulo'] ?? 'Notificação';
                    $mensagem = $data['mensagem'] ?? '';
                    $url = $data['url'] ?? '#';
                    $isUnread = is_null($notif->read_at);
                @endphp
                <div class="flex items-start gap-3.5 px-5 py-4 transition-all duration-150 {{ $isUnread ? 'bg-surface-container-low' : '' }}">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 {{ $isUnread ? 'bg-primary text-on-primary' : 'bg-surface-variant text-on-surface-variant' }}">
                        <i class="fa-solid fa-{{ $icone }}" style="font-size: 0.9rem;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline gap-2">
                            <span class="font-semibold text-on-surface text-body-sm">{{ $titulo }}</span>
                            <span class="text-label-md text-on-surface-variant whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-1 text-body-sm text-on-surface-variant leading-relaxed">{{ $mensagem }}</p>
                    </div>
                    <div class="flex gap-1.5 items-center flex-shrink-0">
                        @if($url !== '#')
                            <a href="{{ $url }}" class="border border-outline-variant rounded-lg p-1.5 text-on-surface-variant hover:bg-surface-variant transition-colors text-body-sm no-underline" title="Abrir">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endif
                        @if($isUnread)
                            <form method="POST" action="{{ route('portal.notificacoes.ler', $notif->id) }}" class="m-0" onsubmit="event.preventDefault(); fetch(this.action, {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}}).then(() => this.closest('.flex').style.opacity='0.5');">
                                @csrf
                                <button type="submit" class="border border-outline-variant rounded-lg p-1.5 text-on-surface-variant hover:bg-surface-variant transition-colors cursor-pointer bg-transparent" title="Marcar como lida">
                                    <i class="fa-regular fa-circle-check"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($notifications->hasPages())
            <div class="px-5 py-4 border-t border-outline-variant/30">
                {{ $notifications->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
