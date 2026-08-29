@props(['activeRoute' => 'dashboard'])

@php
    $p = Auth::user()->paciente;
    $unreadMsgs = $p
        ? $p->conversas()->with('mensagens')->get()->flatMap(fn ($c) => $c->mensagens)->where('remetente_id', '!=', Auth::id())->where('lida', false)->count()
        : 0;
    $newDocs = $p ? $p->documentos()->where('novo', true)->count() : 0;
    $planoNome = $p?->subscricaoActiva?->plano?->nome ?? null;

    $nav = [
        ['route' => 'dashboard',   'icon' => 'dashboard',          'label' => 'Dashboard'],
        ['route' => 'consultas',   'icon' => 'calendar_month',     'label' => 'Consultas'],
        ['route' => 'mensagens',   'icon' => 'chat',               'label' => 'Mensagens', 'badge' => $unreadMsgs],
        ['route' => 'plano',       'icon' => 'medical_services',   'label' => 'Planos'],
        ['route' => 'ficha',       'icon' => 'description',        'label' => 'Ficha Clínica'],
        ['route' => 'documentos',  'icon' => 'assessment',         'label' => 'Relatórios', 'badge' => $newDocs],
        ['route' => 'perfil',      'icon' => 'person',             'label' => 'Perfil'],
    ];

    $isActive = fn($r) => request()->routeIs($r);
@endphp

<aside class="hidden md:flex fixed left-0 top-0 h-full w-[280px] bg-surface border-r border-outline-variant flex-col py-stack-lg z-50">
    <div class="px-gutter mb-10 flex justify-between items-start">
        <div>
            <h1 class="font-headline-md text-headline-md font-bold text-primary">MindCare</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Portal do Paciente</p>
            @if($planoNome)
                <p class="font-label-md text-[10px] text-primary/80 mt-1 uppercase tracking-wider">{{ $planoNome }}</p>
            @endif
        </div>
        <button class="md:hidden w-10 h-10 text-on-surface-variant hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors" onclick="document.querySelector('aside').classList.add('hidden')"><span class="material-symbols-outlined">close</span></button>
    </div>
    
    <nav class="flex-grow space-y-1">
        @foreach($nav as $item)
            <a class="flex items-center gap-3 px-6 py-3 transition-all duration-200
                      {{ $isActive($item['route']) 
                          ? 'border-l-4 border-primary bg-surface-container-high text-on-surface font-bold' 
                          : 'text-on-surface-variant hover:bg-surface-variant' }}" 
               href="{{ route($item['route']) }}">
                <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                <span class="font-body-md text-body-md">{{ $item['label'] }}</span>
                @if(isset($item['badge']) && $item['badge'] > 0)
                    <span class="ml-auto bg-error text-on-error font-bold text-[10px] min-w-[18px] h-[18px] rounded-full flex items-center justify-center px-1">
                        {{ $item['badge'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>
    
    <div class="px-6 mt-6">
    </div>
    
    <footer class="mt-auto px-6">
        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="m-0">
            @csrf
            <button type="submit" class="flex items-center gap-3 py-2 text-error hover:opacity-80 transition-colors w-full text-left cursor-pointer bg-transparent border-none p-0 outline-none">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-body-md text-body-md font-medium">Sair</span>
            </button>
        </form>
    </footer>
</aside>
