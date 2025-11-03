@extends('layouts.app')

@section('title', 'Novo Automóvel')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">➕ Cadastrar Novo Automóvel</h4>
            </div>
            <div class="card-body">
                {{-- Exibir erros de validação --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ops! Há alguns erros:</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('automoveis.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="placa" class="form-label">Placa *</label>
                            <input type="text" class="form-control @error('placa') is-invalid @enderror" 
                                   id="placa" name="placa" value="{{ old('placa') }}" required maxlength="8">
                            @error('placa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modelo" class="form-label">Modelo *</label>
                            <input type="text" class="form-control @error('modelo') is-invalid @enderror" 
                                   id="modelo" name="modelo" value="{{ old('modelo') }}" required>
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="marca" class="form-label">Marca *</label>
                            <input type="text" class="form-control @error('marca') is-invalid @enderror" 
                                   id="marca" name="marca" value="{{ old('marca') }}" required>
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="">Selecione...</option>
                                <option value="SEDAN" {{ old('tipo') == 'SEDAN' ? 'selected' : '' }}>Sedan</option>
                                <option value="SUV" {{ old('tipo') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                <option value="HATCH" {{ old('tipo') == 'HATCH' ? 'selected' : '' }}>Hatch</option>
                                <option value="VAN" {{ old('tipo') == 'VAN' ? 'selected' : '' }}>Van</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ano_fabricacao" class="form-label">Ano *</label>
                            <input type="number" class="form-control @error('ano_fabricacao') is-invalid @enderror" 
                                   id="ano_fabricacao" name="ano_fabricacao" value="{{ old('ano_fabricacao') }}" required>
                            @error('ano_fabricacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="cor" class="form-label">Cor *</label>
                            <input type="text" class="form-control @error('cor') is-invalid @enderror" 
                                   id="cor" name="cor" value="{{ old('cor') }}" required>
                            @error('cor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="capacidade_passageiros" class="form-label">Passageiros *</label>
                            <input type="number" class="form-control @error('capacidade_passageiros') is-invalid @enderror" 
                                   id="capacidade_passageiros" name="capacidade_passageiros" 
                                   value="{{ old('capacidade_passageiros') }}" required>
                            @error('capacidade_passageiros')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="foto_veiculo" class="form-label">URL da Foto *</label>
                            <input type="text" class="form-control @error('foto_veiculo') is-invalid @enderror" 
                                   id="foto_veiculo" name="foto_veiculo" value="{{ old('foto_veiculo') }}" required>
                            @error('foto_veiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status_veiculo" class="form-label">Status</label>
                            <select class="form-select @error('status_veiculo') is-invalid @enderror" 
                                    id="status_veiculo" name="status_veiculo">
                                <option value="DISPONIVEL" {{ old('status_veiculo') == 'DISPONIVEL' ? 'selected' : '' }}>Disponível</option>
                                <option value="INDISPONIVEL" {{ old('status_veiculo') == 'INDISPONIVEL' ? 'selected' : '' }}>Indisponível</option>
                                <option value="MANUTENCAO" {{ old('status_veiculo') == 'MANUTENCAO' ? 'selected' : '' }}>Manutenção</option>
                            </select>
                            @error('status_veiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="motorista_id" class="form-label">ID do Motorista *</label>
                        <input type="number" class="form-control @error('motorista_id') is-invalid @enderror" 
                               id="motorista_id" name="motorista_id" value="{{ old('motorista_id') }}" required>
                        @error('motorista_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            ✅ Salvar Automóvel
                        </button>
                        <a href="{{ route('automoveis.index') }}" class="btn btn-secondary">
                            ❌ Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection