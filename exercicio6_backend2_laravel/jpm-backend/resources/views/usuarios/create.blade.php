@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">➕ Cadastrar Novo Usuário</h4>
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

                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Informações Pessoais</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                   id="nome" name="nome" value="{{ old('nome') }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                   id="cpf" name="cpf" value="{{ old('cpf') }}" required maxlength="14"
                                   placeholder="000.000.000-00">
                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="senha" class="form-label">Senha *</label>
                            <input type="password" class="form-control @error('senha') is-invalid @enderror" 
                                   id="senha" name="senha" required minlength="6">
                            @error('senha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento *</label>
                            <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" 
                                   id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}" required>
                            @error('data_nascimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="idade" class="form-label">Idade *</label>
                            <input type="number" class="form-control @error('idade') is-invalid @enderror" 
                                   id="idade" name="idade" value="{{ old('idade') }}" required>
                            @error('idade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="sexo" class="form-label">Sexo *</label>
                            <select class="form-select @error('sexo') is-invalid @enderror" id="sexo" name="sexo" required>
                                <option value="">Selecione...</option>
                                <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                                <option value="FEMININO" {{ old('sexo') == 'FEMININO' ? 'selected' : '' }}>Feminino</option>
                                <option value="OUTRO" {{ old('sexo') == 'OUTRO' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('sexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone *</label>
                            <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                   id="telefone" name="telefone" value="{{ old('telefone') }}" required
                                   placeholder="(00) 00000-0000">
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nacionalidade" class="form-label">Nacionalidade *</label>
                            <input type="text" class="form-control @error('nacionalidade') is-invalid @enderror" 
                                   id="nacionalidade" name="nacionalidade" value="{{ old('nacionalidade', 'Brasileira') }}" required>
                            @error('nacionalidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço Completo *</label>
                        <textarea class="form-control @error('endereco') is-invalid @enderror" 
                                  id="endereco" name="endereco" rows="2" required>{{ old('endereco') }}</textarea>
                        @error('endereco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <h5 class="mb-3">Informações da Conta</h5>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuário *</label>
                            <select class="form-select @error('tipo_usuario') is-invalid @enderror" 
                                    id="tipo_usuario" name="tipo_usuario" required>
                                <option value="">Selecione...</option>
                                <option value="ADMINISTRADOR" {{ old('tipo_usuario') == 'ADMINISTRADOR' ? 'selected' : '' }}>Administrador</option>
                                <option value="PASSAGEIRO" {{ old('tipo_usuario') == 'PASSAGEIRO' ? 'selected' : '' }}>Passageiro</option>
                                <option value="MOTORISTA" {{ old('tipo_usuario') == 'MOTORISTA' ? 'selected' : '' }}>Motorista</option>
                            </select>
                            @error('tipo_usuario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status_conta" class="form-label">Status da Conta</label>
                            <select class="form-select @error('status_conta') is-invalid @enderror" 
                                    id="status_conta" name="status_conta">
                                <option value="PENDENTE" {{ old('status_conta') == 'PENDENTE' ? 'selected' : '' }}>Pendente</option>
                                <option value="ATIVO" {{ old('status_conta') == 'ATIVO' ? 'selected' : '' }}>Ativo</option>
                                <option value="INATIVO" {{ old('status_conta') == 'INATIVO' ? 'selected' : '' }}>Inativo</option>
                                <option value="BLOQUEADO" {{ old('status_conta') == 'BLOQUEADO' ? 'selected' : '' }}>Bloqueado</option>
                            </select>
                            @error('status_conta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="email_verificado" class="form-label">Email Verificado</label>
                            <select class="form-select @error('email_verificado') is-invalid @enderror" 
                                    id="email_verificado" name="email_verificado">
                                <option value="0" {{ old('email_verificado') == '0' ? 'selected' : '' }}>Não</option>
                                <option value="1" {{ old('email_verificado') == '1' ? 'selected' : '' }}>Sim</option>
                            </select>
                            @error('email_verificado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ultima_atividade" class="form-label">Última Atividade *</label>
                            <input type="datetime-local" class="form-control @error('ultima_atividade') is-invalid @enderror" 
                                   id="ultima_atividade" name="ultima_atividade" 
                                   value="{{ old('ultima_atividade', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('ultima_atividade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="foto_identidade" class="form-label">URL Foto Identidade</label>
                            <input type="text" class="form-control @error('foto_identidade') is-invalid @enderror" 
                                   id="foto_identidade" name="foto_identidade" value="{{ old('foto_identidade') }}">
                            @error('foto_identidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-success">
                            ✅ Salvar Usuário
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                            ❌ Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection