## AQUI VAI O ESBOCO DO BANCO DE DADOS PARA GERAR A TABELA + OS INSERTS

//Modelo fisico - https://dbdiagram.io/d/db_fisico-686dec5af413ba3508f55ade

//PRONTO O BANCO DE DADOS 

CREATE DATABASE sistema_caronas;
USE sistema_caronas;

-- ============================================
-- TABELA USUARIOS (base - campos comuns)
-- ============================================

-- 11
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- Campos da classe Usuario (base) 
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    idade INT NOT NULL,
    sexo VARCHAR(10) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    data_nascimento DATE NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    endereco TEXT NOT NULL,
    nacionalidade VARCHAR(100) NOT NULL,
    ultima_atividade DATETIME NOT NULL,
    email_verificado BOOLEAN DEFAULT FALSE,
    status_conta VARCHAR(50) DEFAULT 'PENDENTE',
    foto_identidade VARCHAR(255) DEFAULT '',
    
    -- Campo para herança
    tipo_usuario ENUM('ADMINISTRADOR', 'PASSAGEIRO', 'MOTORISTA') NOT NULL
);

-- ============================================
-- TABELAS ESPECÍFICAS (herança)
-- ============================================

-- 1 - Administradores
CREATE TABLE administradores (
    usuario_id INT PRIMARY KEY,
    data_atividade DATETIME NOT NULL,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- 2 - Passageiros
CREATE TABLE passageiros (
    usuario_id INT PRIMARY KEY,
    apelido VARCHAR(100) NOT NULL,
    fotoPerfil VARCHAR(255) DEFAULT '',
    descricao_perfil TEXT DEFAULT '',
    preferencias_linguagem VARCHAR(50) DEFAULT '',
    modo_favorito VARCHAR(50) DEFAULT '',
    frequencia_uso INT DEFAULT 0,
    aceita_compartilhamento BOOLEAN DEFAULT TRUE,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- 3 - Motoristas
CREATE TABLE motoristas (
    usuario_id INT PRIMARY KEY,
    cnh VARCHAR(20) NOT NULL,
    validade_cnh DATE NOT NULL,
    categoria_cnh VARCHAR(10) NOT NULL,
    foto_cnh VARCHAR(255) NOT NULL,
    data_aprovacao INT DEFAULT 0,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- ============================================
-- TABELA AUTOMOVEL (composição com Motorista)
-- ============================================

-- 4
CREATE TABLE automovel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(8) NOT NULL UNIQUE,
    modelo VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    marca VARCHAR(50) NOT NULL,
    ano_fabricacao INT NOT NULL,
    cor VARCHAR(30) NOT NULL,
    capacidade_passageiros INT NOT NULL,
    foto_veiculo VARCHAR(255) NOT NULL,
    status_veiculo VARCHAR(50) DEFAULT 'DISPONIVEL',
    
    -- FK para motorista (agora referencia a tabela motoristas)
    motorista_id INT NOT NULL,
    
    FOREIGN KEY (motorista_id) REFERENCES motoristas(usuario_id) ON DELETE CASCADE
);

-- ============================================
-- TABELA VIAGEM
-- ============================================

-- 5
CREATE TABLE viagem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NULL,
    origem VARCHAR(255) NOT NULL,
    destino VARCHAR(255) NOT NULL,
    distancia DECIMAL(10,2) NOT NULL,
    duracao DECIMAL(10,2) NOT NULL,
    status_viagem VARCHAR(50) DEFAULT 'PENDENTE',
    rota TEXT NOT NULL,
    tempoEspera DECIMAL(5,2) DEFAULT 0,
    aceite_motorista BOOLEAN DEFAULT FALSE,
    
    -- FK para motorista
    motorista_id INT NOT NULL,
    
    FOREIGN KEY (motorista_id) REFERENCES motoristas(usuario_id) ON DELETE CASCADE
);

-- ============================================
-- TABELA AVALIACAO
-- ============================================

-- 6
CREATE TABLE avaliacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nota INT NOT NULL CHECK (nota >= 1 AND nota <= 5),
    comentario TEXT NOT NULL,
    data_avaliacao DATETIME NOT NULL,
    tipo_avaliacao VARCHAR(50) NOT NULL,
    
    -- FKs
    motorista_id INT NOT NULL,
    passageiro_id INT NOT NULL,
    viagem_id INT NOT NULL,

    FOREIGN KEY (motorista_id) REFERENCES motoristas(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (passageiro_id) REFERENCES passageiros(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (viagem_id) REFERENCES viagem(id) ON DELETE CASCADE
);

-- ============================================
-- TABELA MENSAGEM
-- ============================================

-- 7
CREATE TABLE mensagem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conteudo TEXT NOT NULL,
    data_envio DATETIME NOT NULL,
    lida BOOLEAN DEFAULT FALSE,
    
    -- FKs
    viagem_id INT NOT NULL,
    usuario_id INT NOT NULL,
    FOREIGN KEY (viagem_id) REFERENCES viagem(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- ============================================
-- TABELA NOTIFICACAO
-- ============================================

-- 8
CREATE TABLE notificacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio INT NOT NULL, -- timestamp
    lida BOOLEAN DEFAULT FALSE,
    tipo_notificacao INT NOT NULL,
    
    -- FK opcional para viagem
    viagem_id INT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (viagem_id) REFERENCES viagem(id) ON DELETE CASCADE
);

-- ============================================
-- TABELA DENUNCIA
-- ============================================

-- 9
CREATE TABLE denuncia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dataEnvio DATETIME NOT NULL,
    descricao TEXT NOT NULL,
    tipoDenuncia VARCHAR(100) NOT NULL,
    statusDenuncia VARCHAR(50) DEFAULT 'ABERTA',
    evidencia VARCHAR(255) NOT NULL,
    dataResposta DATETIME NOT NULL,
    resposta TEXT DEFAULT '',
    
    -- FKs
    denunciado_id INT NOT NULL,
    administrador_id INT NOT NULL,
    viagem_id INT NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (denunciado_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (administrador_id) REFERENCES administradores(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (viagem_id) REFERENCES viagem(id) ON DELETE CASCADE
);

-- ============================================
-- TABELA PAGAMENTO
-- ============================================

-- 10
CREATE TABLE pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_pagamento DATETIME NOT NULL,
    data_confirmacao DATETIME NULL,
    valor DECIMAL(10,2) NOT NULL,
    status_pagamento VARCHAR(50) DEFAULT 'PENDENTE',
    forma_pagamento VARCHAR(50) NOT NULL,
    comprovante VARCHAR(255) DEFAULT '',
    
    -- FKs
    passageiro_id INT NOT NULL,
    viagem_id INT NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (passageiro_id) REFERENCES passageiros(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (viagem_id) REFERENCES viagem(id) ON DELETE CASCADE
);

-- ============================================
-- TABELAS DE RELACIONAMENTO N:N
-- ============================================

-- Viagem x Passageiros
CREATE TABLE viagem_passageiros (
    viagem_id INT NOT NULL,
    passageiro_id INT NOT NULL,
    
    PRIMARY KEY (viagem_id, passageiro_id),
    FOREIGN KEY (viagem_id) REFERENCES viagem(id) ON DELETE CASCADE,
    FOREIGN KEY (passageiro_id) REFERENCES passageiros(usuario_id) ON DELETE CASCADE
);

-- Notificacao x Usuarios
CREATE TABLE notificacao_usuarios (
    notificacao_id INT NOT NULL,
    usuario_id INT NOT NULL,
    
    PRIMARY KEY (notificacao_id, usuario_id),
    FOREIGN KEY (notificacao_id) REFERENCES notificacao(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Notificacao x Denuncias
CREATE TABLE notificacao_denuncias (
    notificacao_id INT NOT NULL,
    denuncia_id INT NOT NULL,
    
    PRIMARY KEY (notificacao_id, denuncia_id),
    FOREIGN KEY (notificacao_id) REFERENCES notificacao(id) ON DELETE CASCADE,
    FOREIGN KEY (denuncia_id) REFERENCES denuncia(id) ON DELETE CASCADE
);

-- Denuncia x Denunciantes
CREATE TABLE denuncia_denunciantes (
    denuncia_id INT NOT NULL,
    denunciante_id INT NOT NULL,
    
    PRIMARY KEY (denuncia_id, denunciante_id),
    FOREIGN KEY (denuncia_id) REFERENCES denuncia(id) ON DELETE CASCADE,
    FOREIGN KEY (denunciante_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

/* ordem dos inserts 

usuarios (tabela base)
administradores (depende de usuarios)
passageiros (depende de usuarios)
motoristas (depende de usuarios)
automovel (depende de motoristas)
viagem (depende de motoristas)
avaliacao (depende de motoristas, passageiros e viagem)
mensagem (depende de viagem e usuarios)
notificacao (depende de viagem)
denuncia (depende de usuarios, administradores e viagem)
pagamento (depende de passageiros e viagem)
viagem_passageiros (depende de viagem e passageiros)
notificacao_usuarios (depende de notificacao e usuarios)
notificacao_denuncias (depende de notificacao e denuncia)
denuncia_denunciantes (depende de denuncia e usuarios)

*/




-- INSERTS PARA DADOS INICIAIS


-- nao recomendo dar insert nesse do usuario (sugiro criar os dados manualmente via postman, pois as senhas estao sendo hasheadas)


INSERT INTO usuarios (nome, email, senha, idade, sexo, telefone, data_nascimento, cpf, endereco, nacionalidade, ultima_atividade, email_verificado, status_conta, foto_identidade, tipo_usuario) VALUES
('João Silva', 'joao.silva@email.com', '123456', 28, 'MASCULINO', '11987654321', '1995-05-15', '123.456.789-01', 'Rua das Flores, 123 - São Paulo, SP', 'Brasileira', '2024-01-15 14:30:00', TRUE, 'ATIVO', 'foto_joao.jpg', 'ADMINISTRADOR'),
('Maria Santos', 'maria.santos@email.com', '123456', 25, 'FEMININO', '11987654322', '1998-08-22', '234.567.890-12', 'Av. Paulista, 456 - São Paulo, SP', 'Brasileira', '2024-01-15 16:45:00', TRUE, 'ATIVO', 'foto_maria.jpg', 'ADMINISTRADOR'),
('Pedro Oliveira', 'pedro.oliveira@email.com', '123456', 32, 'MASCULINO', '11987654323', '1991-12-10', '345.678.901-23', 'Rua Augusta, 789 - São Paulo, SP', 'Brasileira', '2024-01-15 18:20:00', TRUE, 'ATIVO', 'foto_pedro.jpg', 'PASSAGEIRO'),
('Ana Costa', 'ana.costa@email.com', '123456', 29, 'FEMININO', '11987654324', '1994-03-18', '456.789.012-34', 'Rua da Consolação, 321 - São Paulo, SP', 'Brasileira', '2024-01-15 19:15:00', TRUE, 'ATIVO', 'foto_ana.jpg', 'PASSAGEIRO'),
('Carlos Ferreira', 'carlos.ferreira@email.com', '123456', 35, 'MASCULINO', '11987654325', '1988-07-25', '567.890.123-45', 'Av. Brasil, 654 - São Paulo, SP', 'Brasileira', '2024-01-15 20:30:00', TRUE, 'ATIVO', 'foto_carlos.jpg', 'PASSAGEIRO'),
('Lucia Almeida', 'lucia.almeida@email.com', '123456', 27, 'FEMININO', '11987654326', '1996-11-05', '678.901.234-56', 'Rua Liberdade, 987 - São Paulo, SP', 'Brasileira', '2024-01-15 21:45:00', TRUE, 'ATIVO', 'foto_lucia.jpg', 'PASSAGEIRO'),
('Roberto Lima', 'roberto.lima@email.com', '123456', 30, 'MASCULINO', '11987654327', '1993-09-12', '789.012.345-67', 'Av. Ipiranga, 147 - São Paulo, SP', 'Brasileira', '2024-01-15 22:10:00', TRUE, 'ATIVO', 'foto_roberto.jpg', 'PASSAGEIRO'),
('Fernanda Souza', 'fernanda.souza@email.com', '123456', 26, 'FEMININO', '11987654328', '1997-04-30', '890.123.456-78', 'Rua São Bento, 258 - São Paulo, SP', 'Brasileira', '2024-01-15 23:25:00', TRUE, 'ATIVO', 'foto_fernanda.jpg', 'MOTORISTA'),
('Thiago Santos', 'thiago.santos@email.com', '123456', 31, 'MASCULINO', '11987654329', '1992-06-08', '901.234.567-89', 'Av. Faria Lima, 369 - São Paulo, SP', 'Brasileira', '2024-01-16 08:15:00', TRUE, 'ATIVO', 'foto_thiago.jpg', 'MOTORISTA'),
('Juliana Rocha', 'juliana.rocha@email.com', '123456', 24, 'FEMININO', '11987654330', '1999-01-20', '012.345.678-90', 'Rua Oscar Freire, 741 - São Paulo, SP', 'Brasileira', '2024-01-16 09:30:00', TRUE, 'ATIVO', 'foto_juliana.jpg', 'MOTORISTA');

INSERT INTO administradores (usuario_id, data_atividade) VALUES
(1, '2024-01-15 14:30:00'),
(2, '2024-01-10 09:15:00');

INSERT INTO passageiros (usuario_id, apelido, fotoPerfil, descricao_perfil, preferencias_linguagem, modo_favorito, frequencia_uso, aceita_compartilhamento) VALUES
(3, 'Pedro', 'perfil_pedro.jpg', 'Adoro viajar e conhecer pessoas novas!', 'Português', 'Econômico', 15, FALSE),
(4, 'Ana', 'perfil_ana.jpg', 'Sempre pontual e organizada', 'Português', 'Conforto', 22, TRUE),
(5, 'Carlos', 'perfil_carlos.jpg', 'Gosto de conversar durante as viagens', 'Português', 'Rápido', 8, TRUE),
(6, 'Lucia', 'perfil_lucia.jpg', 'Prefiro viagens silenciosas', 'Português', 'Econômico', 12, TRUE),
(7, 'LAKAKA', 'perfil_lakaka.jpg', 'Prefiro viagens silenciosas', 'Português', 'Econômico', 6, FALSE);

INSERT INTO motoristas (usuario_id, cnh, validade_cnh, categoria_cnh, foto_cnh, data_aprovacao) VALUES
(8, '34567890123', '2025-09-12', 'B', 'cnh_003.jpg', 1642204800),
(9, '45678901234', '2026-06-08', 'B', 'cnh_004.jpg', 1642204800),
(10, '56789012345', '2025-03-15', 'B', 'cnh_005.jpg', 1642204800);


INSERT INTO automovel (placa, modelo, tipo, marca, ano_fabricacao, cor, capacidade_passageiros, foto_veiculo, status_veiculo, motorista_id) VALUES
('GHI9012', 'Onix', 'Hatch', 'Chevrolet', 2021, 'Preto', 4, 'onix_003.jpg', 'DISPONIVEL', 8),
('JKL3456', 'HB20', 'Hatch', 'Hyundai', 2020, 'Azul', 4, 'hb20_004.jpg', 'MANUTENCAO', 9),
('MNO7890', 'Fit', 'Hatch', 'Honda', 2018, 'Vermelho', 4, 'fit_005.jpg', 'INDISPONIVEL', 10);

INSERT INTO viagem (data_inicio, data_fim, origem, destino, distancia, duracao, status_viagem, rota, tempoEspera, aceite_motorista, motorista_id) VALUES
('2024-01-16 08:00:00', '2024-01-16 08:45:00', 'Shopping Ibirapuera', 'Pelotas', 12.5, 45.0, 'CONCLUIDA', 'Rota via Av. 23 de Maio', 5.0, TRUE, 8),
('2024-01-16 18:30:00', '2024-01-16 19:15:00', 'Estação da Sé', 'Florianopolis', 8.7, 45.0, 'CONCLUIDA', 'Rota via Minhocão', 3.0, TRUE, 9),
('2024-01-17 07:15:00', '2024-01-17 08:00:00', 'Morumbi', 'Porto Alegre', 15.2, 45.0, 'CONCLUIDA', 'Rota via Marginal Pinheiros', 2.0, TRUE, 10);


INSERT INTO avaliacao (nota, comentario, data_avaliacao, tipo_avaliacao, motorista_id, passageiro_id, viagem_id) VALUES
(5, 'Excelente motorista! Pontual e carro limpo.', '2024-01-16 09:00:00', 'MOTORISTA', 8, 4, 1),
(4, 'Boa viagem, mas poderia ter sido mais rápido.', '2024-01-16 19:30:00', 'MOTORISTA', 8, 5, 1),
(5, 'Perfeito! Recomendo muito este motorista.', '2024-01-17 08:15:00', 'MOTORISTA', 8, 6, 1),
(3, 'Viagem ok, mas motorista falava muito alto.', '2024-01-17 14:20:00', 'MOTORISTA', 9, 7, 2),
(4, 'Passageira educada e pontual.', '2024-01-17 20:10:00', 'PASSAGEIRO', 10, 3, 3);

INSERT INTO mensagem (conteudo, data_envio, lida, viagem_id, usuario_id) VALUES
('Olá! Já estou a caminho do ponto de encontro.', '2024-01-16 07:55:00', TRUE, 1, 4),
('Perfeito! Estou aguardando no local combinado.', '2024-01-16 07:56:00', TRUE, 1, 8),
('Chegando em 2 minutos!', '2024-01-16 07:58:00', TRUE, 1, 5),
('Boa tarde! Confirma o endereço: Vila Madalena, 123?', '2024-01-16 18:25:00', TRUE, 2, 7),
('Isso mesmo! Obrigada.', '2024-01-16 18:26:00', TRUE, 2, 9),
('Estou no trânsito, atraso de 5 minutos.', '2024-01-17 07:20:00', TRUE, 3, 10),
('Sem problemas! Aguardo.', '2024-01-17 07:21:00', TRUE, 3, 3);


INSERT INTO notificacao (titulo, mensagem, data_envio, lida, tipo_notificacao, viagem_id) VALUES
('Viagem Confirmada!', 'Sua viagem foi confirmada para hoje às 08:00', 1642291200, TRUE, 1, 1),
('Motorista a caminho', 'Seu motorista está a caminho do ponto de encontro', 1642291800, TRUE, 2, 1),
('Viagem Concluída', 'Sua viagem foi concluída com sucesso. Avalie sua experiência!', 1642294500, FALSE, 3, 1),
('Nova Solicitação', 'Você tem uma nova solicitação de carona', 1642377000, TRUE, 4, 2),
('Pagamento Processado', 'Seu pagamento foi processado com sucesso', 1642294800, TRUE, 5, 1),
('Cancelamento de Viagem', 'Sua viagem foi cancelada pelo motorista', 1642380600, FALSE, 6, 2),
('Avaliação Pendente', 'Não se esqueça de avaliar sua última viagem', 1642467000, FALSE, 7, 3);


INSERT INTO denuncia (dataEnvio, descricao, tipoDenuncia, statusDenuncia, evidencia, dataResposta, resposta, denunciado_id, administrador_id, viagem_id) VALUES
('2024-01-16 10:00:00', 'Motorista dirigindo de forma imprudente', 'COMPORTAMENTO_PERIGOSO', 'ANALISANDO', 'video_evidencia1.mp4', '2024-01-16 10:00:00', '', 8, 1, 1),
('2024-01-16 20:00:00', 'Passageiro foi grosseiro durante a viagem', 'COMPORTAMENTO_INADEQUADO', 'RESOLVIDA', 'audio_evidencia2.mp3', '2024-01-17 08:00:00', 'Advertência aplicada ao usuário', 4, 1,1),
('2024-01-16 10:00:00', 'Passageiro vomitou no carro', 'COMPORTAMENTO_INADEQUADO', 'PENDENTE', 'video_evidencia3.mp4', '2024-01-16 10:00:00', '', 7,2,2);


INSERT INTO pagamento (data_pagamento, data_confirmacao, valor, status_pagamento, forma_pagamento, comprovante, passageiro_id, viagem_id) VALUES
('2024-01-16 08:50:00', '2024-01-16 08:51:00', 15.50, 'CONFIRMADO', 'PIX', 'comprovante_pix_001.pdf', 4, 1),
('2024-01-16 19:20:00', '2024-01-16 19:21:00', 12.80, 'CONFIRMADO', 'CARTAO_CREDITO', 'comprovante_cartao_002.pdf', 5,1),
('2024-01-17 08:05:00', '2024-01-17 08:06:00', 18.90, 'CONFIRMADO', 'PIX', 'comprovante_pix_003.pdf', 6, 1),
('2024-01-17 19:30:00', NULL, 22.40, 'PENDENTE', 'CARTAO_DEBITO', '', 7,2),
('2024-01-18 07:00:00', NULL, 25.60, 'PENDENTE', 'PIX', '', 3,3);


INSERT INTO viagem_passageiros (viagem_id, passageiro_id) VALUES (1, 4),(1, 5),(1, 6),(2, 7),(3,3);

INSERT INTO notificacao_usuarios (notificacao_id, usuario_id) VALUES (1, 3),(2,4),(3, 5),(4,6);

INSERT INTO notificacao_denuncias (notificacao_id, denuncia_id) VALUES (1, 1),(2, 2),(3, 3),(4, 3);

/*aqui mesmo o tu tendo duas denuncias em uma mesma viagem o id tem que ser diferente pra nao dar redundancia de dados (vou ter que fazer um select pra juntar tudo) */
INSERT INTO denuncia_denunciantes (denuncia_id, denunciante_id) VALUES (1, 4),(2, 8),(3,9);



-- ============================================
-- ÍNDICES PARA PERFORMANCE
-- ============================================
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_cpf ON usuarios(cpf);
CREATE INDEX idx_usuarios_tipo ON usuarios(tipo_usuario);
CREATE INDEX idx_viagem_motorista ON viagem(motorista_id);
CREATE INDEX idx_viagem_status ON viagem(status_viagem);
CREATE INDEX idx_automovel_motorista ON automovel(motorista_id);
CREATE INDEX idx_mensagem_viagem ON mensagem(viagem_id);
CREATE INDEX idx_avaliacao_motorista ON avaliacao(motorista_id);
CREATE INDEX idx_denuncia_denunciado ON denuncia(denunciado_id);
CREATE INDEX idx_pagamento_passageiro ON pagamento(passageiro_id);