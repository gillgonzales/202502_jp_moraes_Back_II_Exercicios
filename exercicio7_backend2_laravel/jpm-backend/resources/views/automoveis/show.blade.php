@extends('layouts.app')

@section('title', 'Detalhes do Automóvel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Detalhes do Automóvel</h1>
    <a href="{{ route('automoveis.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card">
    <div class="card-header bg-secondary text-white">
        <h3>{{ $automovel->marca }} {{ $automovel->modelo }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Informações do Veículo</h5>
                <table class="table">
                    <tr>
                        <th width="40%">ID:</th>
                        <td>{{ $automovel->id }}</td>
                    </tr>
                    <tr>
                        <th>Placa:</th>
                        <td><span class="badge bg-dark">{{ $automovel->placa }}</span></td>
                    </tr>
                    <tr>
                        <th>Marca:</th>
                        <td>{{ $automovel->marca }}</td>
                    </tr>
                    <tr>
                        <th>Modelo:</th>
                        <td>{{ $automovel->modelo }}</td>
                    </tr>
                    <tr>
                        <th>Tipo:</th>
                        <td>{{ $automovel->tipo }}</td>
                    </tr>
                    <tr>
                        <th>Cor:</th>
                        <td>{{ $automovel->cor }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Especificações</h5>
                <table class="table">
                    <tr>
                        <th width="40%">Ano de Fabricação:</th>
                        <td>{{ $automovel->ano_fabricacao }}</td>
                    </tr>
                    <tr>
                        <th>Capacidade:</th>
                        <td>{{ $automovel->capacidade_passageiros }} passageiros</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-{{ $automovel->status_veiculo == 'DISPONIVEL' ? 'success' : 'danger' }}">
                                {{ $automovel->status_veiculo }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>ID do Motorista:</th>
                        <td>{{ $automovel->motorista_id }}</td>
                    </tr>
                    <tr>
                        <th>Foto do Veículo:</th>
                        <td>{{ $automovel->foto_veiculo }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection