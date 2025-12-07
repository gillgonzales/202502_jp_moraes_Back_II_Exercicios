@extends('layouts.app')

@section('title', 'Lista de Notificações')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Notificações</h1>
        <a href="{{ route('notificacoes.create') }}" class="btn btn-success">
            ➕ Nova Notificação
        </a>
    </div>

    {{-- Mensagens de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="list-group">
                @forelse($notificacoes as $notificacao)
                    <div class="list-group-item {{ $notificacao->lida ? '' : 'list-group-item-warning' }}">
                        <div class="d-flex w-100 justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">
                                        {{ $notificacao->titulo }}
                                        @if(!$notificacao->lida)
                                            <span class="badge bg-danger">Nova</span>
                                        @endif
                                    </h5>
                                    <small class="text-muted">{{ date('d/m/Y H:i', $notificacao->data_envio) }}</small>
                                </div>
                                <p class="mb-1">{{ Str::limit($notificacao->mensagem, 100) }}</p>
                                <small class="text-muted">Tipo: {{ $notificacao->tipo_notificacao }}</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('notificacoes.show', $notificacao->id) }}" class="btn btn-sm btn-primary">
                                👁️ Ver Detalhes
                            </a>
                            <a href="{{ route('notificacoes.edit', $notificacao->id) }}" class="btn btn-sm btn-warning">
                                ✏️ Editar
                            </a>
                            <a href="{{ route('notificacoes.confirmDelete', $notificacao->id) }}" class="btn btn-sm btn-danger">
                                🗑️ Deletar
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">Nenhuma notificação encontrada.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection