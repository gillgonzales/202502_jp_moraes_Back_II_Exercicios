composer create-project laravel/laravel jpm-backend

composer require laravel/sail --dev


php artisan sail:install

- cola o composer

version: '3'
    laravel.test:
        build:
            context: ./vendor/laravel/sail/runtimes/8.2
            dockerfile: Dockerfile
            args:
                WWWGROUP: '${WWWGROUP}'
        image: sail-8.2/app
        extra_hosts:
            - 'host.docker.internal:host-gateway'
        ports:
            - '8090:80'
            - '${VITE_PORT:-5173}:${VITE_PORT:-5173}'
        environment:
            WWWUSER: '${WWWUSER}'
            LARAVEL_SAIL: 1
            XDEBUG_MODE: '${SAIL_XDEBUG_MODE:-off}'
            XDEBUG_CONFIG: '${SAIL_XDEBUG_CONFIG:-client_host=host.docker.internal}'
        volumes:
            - '.:/var/www/html'
        networks:
            - sail
        depends_on:
            - mariadb
    mariadb:
        image: 'mariadb:10'
        ports:
            - '${FORWARD_DB_PORT:-3311}:3306'
        environment:
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ROOT_HOST: '%'
            MYSQL_DATABASE: '${DB_DATABASE}'
            MYSQL_USER: '${DB_USERNAME}'
            MYSQL_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ALLOW_EMPTY_PASSWORD: 'yes'
        volumes:
            - 'sail-mariadb:/var/lib/mysql'
            - './vendor/laravel/sail/database/mysql/create-testing-database.sh:/docker-entrypoint-initdb.d/10-create-testing-database.sh'
        networks:
            - sail
        healthcheck:
            test:
                - CMD
                - mysqladmin
                - ping
                - '-p${DB_PASSWORD}'
            retries: 3
            timeout: 5s
    phpmyadmin:
        image: 'phpmyadmin/phpmyadmin:latest'
        ports:
          - '8091:80'
        environment:
            PMA_HOST: 'mariadb'
        networks:
            - sail
        depends_on:
            - mariadb
networks:
    sail:
        driver: bridge
volumes:
    sail-mariadb:
        driver: local

/* criando o alias */


nano ~/.bashrc

- cola o comando abaixo

alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'

- aperta esc e dale + :wq!

source ~/.bashrc


/*executando o projeto com docker*/

- sail up

// tabelas sem relacao

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    tipo_usuario ENUM('ADMINISTRADOR', 'PASSAGEIRO', 'MOTORISTA') NOT NULL
);


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
    motorista_id INT NOT NULL
);


CREATE TABLE notificacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio INT NOT NULL,
    lida BOOLEAN DEFAULT FALSE,
    tipo_notificacao INT NOT NULL,
    viagem_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

/*criando as migrations*/

- php artisan make:model Usuario -mc  
- php artisan make:model automovel -mc  
- php artisan make:model notificacao -mc  

/*instalando o sail migration via wsl*/

- sail artisan migrate:install
- sail artisan migrate


/*insercao para teste*/



INSERT INTO usuarios (nome, email, senha, idade, sexo, telefone, data_nascimento, cpf, endereco, nacionalidade, ultima_atividade, email_verificado, status_conta, foto_identidade, tipo_usuario) 
VALUES 
('João Silva', 'admin@ipm.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 35, 'Masculino', '(11) 98765-4321', '1988-05-15', '123.456.789-00', 'Rua das Flores, 123 - São Paulo/SP', 'Brasileira', NOW(), TRUE, 'ATIVO', 'foto_joao.jpg', 'ADMINISTRADOR');


INSERT INTO automovel (placa, modelo, tipo, marca, ano_fabricacao, cor, capacidade_passageiros, foto_veiculo, status_veiculo, motorista_id) 
VALUES 
('ABC1D23', 'Onix', 'Sedan', 'Chevrolet', 2022, 'Branco', 5, 'onix_branco.jpg', 'DISPONIVEL', 2),
('DEF4E56', 'HB20', 'Hatchback', 'Hyundai', 2021, 'Prata', 5, 'hb20_prata.jpg', 'DISPONIVEL', 3),
('GHI7J89', 'Civic', 'Sedan', 'Honda', 2023, 'Preto', 5, 'civic_preto.jpg', 'EM_VIAGEM', 2),
('JKL0M12', 'Kwid', 'Hatchback', 'Renault', 2020, 'Vermelho', 4, 'kwid_vermelho.jpg', 'MANUTENCAO', 3);


INSERT INTO notificacao (titulo, mensagem, data_envio, lida, tipo_notificacao, viagem_id) 
VALUES 
('Bem-vindo ao IPM!', 'Seu cadastro foi realizado com sucesso. Complete seu perfil para começar.', UNIX_TIMESTAMP(), FALSE, 1, NULL),
('Viagem Confirmada', 'Sua viagem para Av. Paulista foi confirmada. O motorista está a caminho!', UNIX_TIMESTAMP(), TRUE, 2, 1),
('Avaliação Pendente', 'Por favor, avalie sua última viagem com Carlos.', UNIX_TIMESTAMP(), FALSE, 3, 1),
('Promoção Especial', 'Ganhe 20% de desconto na próxima corrida! Válido até domingo.', UNIX_TIMESTAMP(), FALSE, 4, NULL),
('Documento Verificado', 'Sua CNH foi verificada e aprovada. Você já pode dirigir!', UNIX_TIMESTAMP(), TRUE, 1, NULL);