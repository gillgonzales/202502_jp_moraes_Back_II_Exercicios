### Criar os usuarios via postman

- senha pra todos os usuarios sera 123456 

(quando for motorista tem que criar como admin no postman e trocar o tipo)


{
    "nome": "Carlos Silva",
    "email": "carlos.silva@admin.com",
    "senha": "123456",
    "idade": 45,
    "sexo": "Masculino",
    "telefone": "(11) 98765-4321",
    "data_nascimento": "1979-08-22",
    "cpf": "12345678901",
    "endereco": "Av. Paulista, 1500 – São Paulo/SP",
    "nacionalidade": "Brasileira",
    "ultima_atividade": "2025-11-18 18:30:00",
    "status_conta": "ATIVO",
    "foto_identidade": "carlos_rg.jpg",
    "tipo_usuario": "ADMINISTRADOR"
}

{
    "nome": "Ana Paula Costa",
    "email": "ana.costa@admin.com",
    "senha": "123456",
    "idade": 38,
    "sexo": "Feminino",
    "telefone": "(21) 99876-5432",
    "data_nascimento": "1986-12-10",
    "cpf": "98765432109",
    "endereco": "Rua do Catete, 230 – Rio de Janeiro/RJ",
    "nacionalidade": "Brasileira",
    "ultima_atividade": "2025-11-18 16:45:00",
    "status_conta": "ATIVO",
    "foto_identidade": "ana_rg.jpg",
    "tipo_usuario": "ADMINISTRADOR"
}

{
    "nome": "João Santos",
    "email": "joao.santos@motorista.com",
    "senha": "123456",
    "idade": 35,
    "sexo": "Masculino",
    "telefone": "(11) 94567-8901",
    "data_nascimento": "1989-03-18",
    "cpf": "45678912345",
    "endereco": "Rua da Consolação, 890 – São Paulo/SP",
    "nacionalidade": "Brasileira",
    "ultima_atividade": "2025-11-18 19:15:00",
    "status_conta": "ATIVO",
    "foto_identidade": "joao_rg.jpg",
    "tipo_usuario": "MOTORISTA"
}


{
    "nome": "Maria Oliveira",
    "email": "maria.oliveira@motorista.com",
    "senha": "123456",
    "idade": 29,
    "sexo": "Feminino",
    "telefone": "(31) 93456-7890",
    "data_nascimento": "1995-07-25",
    "cpf": "78912345678",
    "endereco": "Av. Afonso Pena, 1200 – Belo Horizonte/MG",
    "nacionalidade": "Brasileira",
    "ultima_atividade": "2025-11-18 17:50:00",
    "status_conta": "ATIVO",
    "foto_identidade": "maria_rg.jpg",
    "tipo_usuario": "MOTORISTA"
}

{
    "nome": "Pedro Almeida",
    "email": "pedro.almeida@motorista.com",
    "senha": "123456",
    "idade": 42,
    "sexo": "Masculino",
    "telefone": "(41) 92345-6789",
    "data_nascimento": "1982-11-05",
    "cpf": "32165498712",
    "endereco": "Rua XV de Novembro, 650 – Curitiba/PR",
    "nacionalidade": "Brasileira",
    "ultima_atividade": "2025-11-18 18:10:00",
    "status_conta": "PENDENTE",
    "foto_identidade": "pedro_rg.jpg",
    "tipo_usuario": "MOTORISTA"
}

{
    "nome": "Juliana Ferreira",
    "email": "juliana.ferreira@email.com",
    "senha": "123456",
    "idade": 27,
    "sexo": "Feminino",
    "telefone": "(85) 91234-5678",
    "data_nascimento": "1997-09-30",
    "cpf": "65432198765",
    "endereco": "Av. Beira Mar, 3500 – Fortaleza/CE",
    "nacionalidade": "Brasileira",
    "ultima_atividade": "2025-11-18 16:20:00",
    "status_conta": "ATIVO",
    "foto_identidade": "juliana_rg.jpg",
    "tipo_usuario": "PASSAGEIRO"
}


/*inserts em SQL*/


INSERT INTO motoristas (usuario_id, cnh, validade_cnh, categoria_cnh, foto_cnh, data_aprovacao) VALUES
(7, '34567890123', '2025-09-12', 'B', 'cnh_003.jpg', 1642204800),
(8, '45678901234', '2026-06-08', 'B', 'cnh_004.jpg', 1642204800),
(10, '56789012345', '2025-03-15', 'B', 'cnh_005.jpg', 1642204800);


INSERT INTO viagem (data_inicio, data_fim, origem, destino, distancia, duracao, status_viagem, rota, tempoEspera, aceite_motorista, motorista_id) VALUES
('2024-01-16 08:00:00', '2024-01-16 08:45:00', 'Shopping Ibirapuera', 'Pelotas', 12.5, 45.0, 'CONCLUIDA', 'Rota via Av. 23 de Maio', 5.0, TRUE, 8),
('2024-01-16 18:30:00', '2024-01-16 19:15:00', 'Estação da Sé', 'Florianopolis', 8.7, 45.0, 'CONCLUIDA', 'Rota via Minhocão', 3.0, TRUE, 9),
('2024-01-17 07:15:00', '2024-01-17 08:00:00', 'Morumbi', 'Porto Alegre', 15.2, 45.0, 'CONCLUIDA', 'Rota via Marginal Pinheiros', 2.0, TRUE, 10);


INSERT INTO denuncia (dataEnvio, descricao, tipoDenuncia, statusDenuncia, evidencia, dataResposta, resposta, denunciado_id, administrador_id, viagem_id) VALUES
('2024-01-16 10:00:00', 'teste', 'COMPORTAMENTO_PERIGOSO', 'ANALISANDO', 'video_evidencia1.mp4', '2024-01-16 10:00:00', '', 6, 1, 3),
('2024-01-16 20:00:00', 'teste', 'COMPORTAMENTO_INADEQUADO', 'RESOLVIDA', 'audio_evidencia2.mp3', '2024-01-17 08:00:00', 'Advertência aplicada ao usuário', 14, 1,4);
