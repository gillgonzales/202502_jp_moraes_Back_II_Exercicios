@extends('layouts.app')

@section('title', 'Editar Notificação')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">✏️ Editar Notificação</h4>
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

                <form action="{{ route('notificacoes.update', $notificacao->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título *</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                               id="titulo" name="titulo" value="{{ old('titulo', $notificacao->titulo) }}" 
                               required maxlength="255">
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mensagem" class="form-label">Mensagem *</label>
                        <textarea class="form-control @error('mensagem') is-invalid @enderror" 
                                  id="mensagem" name="mensagem" rows="4" required>{{ old('mensagem', $notificacao->mensagem) }}</textarea>
                        @error('mensagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_envio" class="form-label">Data de Envio (timestamp) *</label>
                            <input type="number" class="form-control @error('data_envio') is-invalid @enderror" 
                                   id="data_envio" name="data_envio" 
                                   value="{{ old('data_envio', $notificacao->data_envio) }}" required>
                            <small class="text-muted">Timestamp atual: {{ time() }}</small>
                            @error('data_envio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_notificacao" class="form-label">Tipo de Notificação *</label>
                            <select class="form-select @error('tipo_notificacao') is-invalid @enderror" 
                                    id="tipo_notificacao" name="tipo_notificacao" required>
                                <option value="">Selecione...</option>
                                <option value="1" {{ old('tipo_notificacao', $notificacao->tipo_notificacao) == '1' ? 'selected' : '' }}>Tipo 1 - Geral</option>
                                <option value="2" {{ old('tipo_notificacao', $notificacao->tipo_notificacao) == '2' ? 'selected' : '' }}>Tipo 2 - Viagem</option>
                                <option value="3" {{ old('tipo_notificacao', $notificacao->tipo_notificacao) == '3' ? 'selected' : '' }}>Tipo 3 - Pagamento</option>
                                <option value="4" {{ old('tipo_notificacao', $notificacao->tipo_notificacao) == '4' ? 'selected' : '' }}>Tipo 4 - Sistema</option>
                            </select>
                            @error('tipo_notificacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lida" class="form-label">Status</label>
                            <select class="form-select @error('lida') is-invalid @enderror" 
                                    id="lida" name="lida">
                                <option value="0" {{ old('lida', $notificacao->lida) == '0' ? 'selected' : '' }}>Não Lida</option>
                                <option value="1" {{ old('lida', $notificacao->lida) == '1' ? 'selected' : '' }}>Lida</option>
                            </select>
                            @error('lida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="viagem_id" class="form-label">ID da Viagem (opcional)</label>
                            <input type="number" class="form-control @error('viagem_id') is-invalid @enderror" 
                                   id="viagem_id" name="viagem_id" 
                                   value="{{ old('viagem_id', $notificacao->viagem_id) }}">
                            <small class="text-muted">Deixe em branco se não houver viagem relacionada</small>
                            @error('viagem_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-warning">
                            ✅ Atualizar Notificação
                        </button>
                        <a href="{{ route('notificacoes.index') }}" class="btn btn-secondary">
                            ❌ Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection