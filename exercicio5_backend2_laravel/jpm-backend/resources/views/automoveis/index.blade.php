@extends('layouts.app')

@section('title', 'Lista de Automóveis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Automóveis</h1>
</div>

<div class="row">
    @forelse($automoveis as $automovel)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">{{ $automovel->marca }} {{ $automovel->modelo }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Placa:</strong> {{ $automovel->placa }}</p>
                <p><strong>Tipo:</strong> {{ $automovel->tipo }}</p>
                <p><strong>Cor:</strong> {{ $automovel->cor }}</p>
                <p><strong>Ano:</strong> {{ $automovel->ano_fabricacao }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $automovel->status_veiculo == 'DISPONIVEL' ? 'success' : 'danger' }}">
                        {{ $automovel->status_veiculo }}
                    </span>
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('automoveis.show', $automovel->id) }}" class="btn btn-primary btn-sm w-100">
                    Ver Detalhes
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Nenhum automóvel cadastrado.</div>
    </div>
    @endforelse
</div>
@endsection