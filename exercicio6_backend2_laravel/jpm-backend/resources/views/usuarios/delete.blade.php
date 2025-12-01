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

                <h5>Tem certeza que deseja deletar este usuário?</h5>
                
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <p><strong>Nome:</strong> {{ $usuario->nome }}</p>
                        <p><strong>Email:</strong> {{ $usuario->email }}</p>
                        <p><strong>CPF:</strong> {{ $usuario->cpf }}</p>
                        <p><strong>Tipo:</strong> <span class="badge bg-info">{{ $usuario->tipo_usuario }}</span></p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            🗑️ Sim, Deletar Definitivamente
                        </button>
                    </form>
                    
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        ❌ Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection