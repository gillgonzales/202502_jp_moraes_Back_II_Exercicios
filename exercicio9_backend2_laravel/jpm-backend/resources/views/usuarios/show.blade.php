@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Detalhes do Usuário</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning">
            ✏️ Editar
        </a>
        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" 
              onsubmit="return confirm('Tem certeza que deseja deletar este usuário?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                🗑️ Deletar
            </button>
        </form>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
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
    <div class="card-header bg-primary text-white">
        <h3>{{ $usuario->nome }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Informações Pessoais</h5>
                <table class="table">
                    <tr>
                        <th width="40%">ID:</th>
                        <td>{{ $usuario->id }}</td>
                    </tr>
                    <tr>
                        <th>Nome:</th>
                        <td>{{ $usuario->nome }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $usuario->email }}</td>
                    </tr>
                    <tr>
                        <th>CPF:</th>
                        <td>{{ $usuario->cpf }}</td>
                    </tr>
                    <tr>
                        <th>Idade:</th>
                        <td>{{ $usuario->idade }} anos</td>
                    </tr>
                    <tr>
                        <th>Sexo:</th>
                        <td>{{ $usuario->sexo }}</td>
                    </tr>
                    <tr>
                        <th>Data de Nascimento:</th>
                        <td>{{ date('d/m/Y', strtotime($usuario->data_nascimento)) }}</td>
                    </tr>
                    <tr>
                        <th>Telefone:</th>
                        <td>{{ $usuario->telefone }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Informações da Conta</h5>
                <table class="table">
                    <tr>
                        <th width="40%">Tipo de Usuário:</th>
                        <td><span class="badge bg-info">{{ $usuario->tipo_usuario }}</span></td>
                    </tr>
                    <tr>
                        <th>Status da Conta:</th>
                        <td>
                            <span class="badge bg-{{ $usuario->status_conta == 'PENDENTE' ? 'warning' : 'success' }}">
                                {{ $usuario->status_conta }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Email Verificado:</th>
                        <td>
                            <span class="badge bg-{{ $usuario->email_verificado ? 'success' : 'danger' }}">
                                {{ $usuario->email_verificado ? 'Sim' : 'Não' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Nacionalidade:</th>
                        <td>{{ $usuario->nacionalidade }}</td>
                    </tr>
                    <tr>
                        <th>Endereço:</th>
                        <td>{{ $usuario->endereco }}</td>
                    </tr>
                    <tr>
                        <th>Última Atividade:</th>
                        <td>{{ date('d/m/Y H:i:s', strtotime($usuario->ultima_atividade)) }}</td>
                    </tr>
                    @if($usuario->foto_identidade)
                    <tr>
                        <th>Foto Identidade:</th>
                        <td>{{ $usuario->foto_identidade }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection