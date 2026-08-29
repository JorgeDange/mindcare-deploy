@extends('layouts.profissional')

@section('title', 'Documentos — Profissional')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="p-12 text-center text-on-surface-variant">
        <span class="material-symbols-outlined text-4xl opacity-30 mb-4 block">folder_open</span>
        <p class="text-body-sm">Redirecionando para Documentos...</p>
    </div>
</div>

<script>window.location.href = '{{ route("profissional.documentos.index") }}';</script>
@endsection