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

                <h5>Tem certeza que deseja deletar este automóvel?</h5>
                
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <p><strong>Marca:</strong> {{ $automovel->marca }}</p>
                        <p><strong>Modelo:</strong> {{ $automovel->modelo }}</p>
                        <p><strong>Placa:</strong> {{ $automovel->placa }}</p>
                        <p><strong>Ano:</strong> {{ $automovel->ano_fabricacao }}</p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <form action="{{ route('automoveis.destroy', $automovel->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            🗑️ Sim, Deletar Definitivamente
                        </button>
                    </form>
                    
                    <a href="{{ route('automoveis.index') }}" class="btn btn-secondary">
                        ❌ Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection