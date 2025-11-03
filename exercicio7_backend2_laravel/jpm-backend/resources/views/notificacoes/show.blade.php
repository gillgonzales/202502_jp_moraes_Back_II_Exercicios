@extends('layouts.app')

@section('title', 'Detalhes da Notificação')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Detalhes da Notificação</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('notificacoes.edit', $notificacao->id) }}" class="btn btn-warning">
            ✏️ Editar
        </a>
        <form action="{{ route('notificacoes.destroy', $notificacao->id) }}" method="POST" 
              onsubmit="return confirm('Tem certeza que deseja deletar esta notificação?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                🗑️ Deletar
            </button>
        </form>
        <a href="{{ route('notificacoes.index') }}" class="btn btn-secondary">
            ⬅️ Voltar
        </a>
    </div>
</div>

{{-- Mensagem de sucesso --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-{{ $notificacao->lida ? 'secondary' : 'warning' }} text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h3>{{ $notificacao->titulo }}</h3>
            @if(!$notificacao->lida)
            <span class="badge bg-danger">Não Lida</span>
            @else
            <span class="badge bg-success">Lida</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th width="20%">ID:</th>
                <td>{{ $notificacao->id }}</td>
            </tr>
            <tr>
                <th>Título:</th>
                <td>{{ $notificacao->titulo }}</td>
            </tr>
            <tr>
                <th>Mensagem:</th>
                <td>{{ $notificacao->mensagem }}</td>
            </tr>
            <tr>
                <th>Data de Envio:</th>
                <td>{{ date('d/m/Y H:i:s', $notificacao->data_envio) }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>
                    <span class="badge bg-{{ $notificacao->lida ? 'success' : 'danger' }}">
                        {{ $notificacao->lida ? 'Lida' : 'Não Lida' }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Tipo:</th>
                <td>{{ $notificacao->tipo_notificacao }}</td>
            </tr>
            @if($notificacao->viagem_id)
            <tr>
                <th>ID da Viagem:</th>
                <td>{{ $notificacao->viagem_id }}</td>
            </tr>
            @endif
            <tr>
                <th>Criado em:</th>
                <td>{{ $notificacao->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <th>Atualizado em:</th>
                <td>{{ $notificacao->updated_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection