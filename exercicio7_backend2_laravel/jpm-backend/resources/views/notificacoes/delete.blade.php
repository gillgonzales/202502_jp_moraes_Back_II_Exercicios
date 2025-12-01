@extends('layouts.app')

@section('title', 'Confirmar Exclusão')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">⚠️ Confirmar Exclusão</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <strong>Atenção!</strong> Esta ação não pode ser desfeita!
                </div>

                <h5>Tem certeza que deseja deletar esta notificação?</h5>
                
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <p><strong>Título:</strong> {{ $notificacao->titulo }}</p>
                        <p><strong>Mensagem:</strong> {{ Str::limit($notificacao->mensagem, 100) }}</p>
                        <p><strong>Data:</strong> {{ date('d/m/Y H:i', $notificacao->data_envio) }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $notificacao->lida ? 'success' : 'danger' }}">
                                {{ $notificacao->lida ? 'Lida' : 'Não Lida' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <form action="{{ route('notificacoes.destroy', $notificacao->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            🗑️ Sim, Deletar Definitivamente
                        </button>
                    </form>
                    
                    <a href="{{ route('notificacoes.index') }}" class="btn btn-secondary">
                        ❌ Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection