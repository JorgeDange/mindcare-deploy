@props(['colunas' => [], 'linhas' => null, 'acoes' => []])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($linhas && $linhas->isNotEmpty())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    @foreach($colunas as $coluna)
                        <th class="py-3 px-4">{{ $coluna }}</th>
                    @endforeach
                    @if(!empty($acoes))
                        <th class="py-3 px-4 text-right">Acções</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
    @if(method_exists($linhas, 'links'))
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $linhas->links() }}
        </div>
    @endif
    @else
    <div class="p-12 text-center text-gray-400">
        <i class="fa-regular fa-database text-4xl mb-4 block"></i>
        <p class="text-sm">Nenhum registo encontrado.</p>
    </div>
    @endif
</div>