@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Usuários</h1>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nome }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->cpf }}</td>
                    <td>
                        <span class="badge bg-info">{{ $usuario->tipo_usuario }}</span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $usuario->status_conta == 'PENDENTE' ? 'warning' : 'success' }}">
                            {{ $usuario->status_conta }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-sm btn-primary">
                            Ver Detalhes
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Nenhum usuário cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection