@extends('layouts.app')

@section('title', 'Lista de Notificações')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Notificações</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="list-group">
            @forelse($notificacoes as $notificacao)
            <a href="{{ route('notificacoes.show', $notificacao->id) }}" 
               class="list-group-item list-group-item-action {{ $notificacao->lida ? '' : 'list-group-item-warning' }}">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        {{ $notificacao->titulo }}
                        @if(!$notificacao->lida)
                        <span class="badge bg-danger">Nova</span>
                        @endif
                    </h5>
                    <small>{{ date('d/m/Y H:i', $notificacao->data_envio) }}</small>
                </div>
                <p class="mb-1">{{ Str::limit($notificacao->mensagem, 100) }}</p>
                <small>Tipo: {{ $notificacao->tipo_notificacao }}</small>
            </a>
            @empty
            <div class="alert alert-info">Nenhuma notificação encontrada.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection