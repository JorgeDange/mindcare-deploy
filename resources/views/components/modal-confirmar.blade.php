@props(['id', 'titulo', 'mensagem', 'acaoBotao' => 'Confirmar', 'formAction' => '#', 'formMethod' => 'DELETE'])

<div id="{{ $id }}" class="hidden fixed inset-0 z-[10002] flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
        <div class="text-center">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $titulo }}</h3>
            <p class="text-sm text-gray-500 mb-6">{{ $mensagem }}</p>
        </div>
        <form method="POST" action="{{ $formAction }}">
            @csrf
            @method($formMethod)
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancelar</button>
                <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">{{ $acaoBotao }}</button>
            </div>
        </form>
    </div>
</div>

@push('modals')
<script>
    document.getElementById('{{ $id }}')?.addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
</script>
@endpush