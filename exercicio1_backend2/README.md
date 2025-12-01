# 📚 Desenvolvimento Back-End 2 - PHP Laravel
## IFSUL - Curso Superior de Tecnologia em Sistemas para Internet - 2025.02

Este repositório contém os materiais e exemplos práticos da disciplina de Desenvolvimento de Back-End 2, focada em PHP e Laravel.

## 📂 Estrutura de Pastas e Arquios do Repositório

```
topico01/
└── revisao_poo_php/
    ├── exemplo_01.php
    ├── exemplo_02.php
    ├── exemplo_03.php
    ├── exemplo_04.php
    ├── exemplo_05.php
    ├── exemplo_06.php
    ├── exemplo_07.php
    ├── exemplo_08.php
    └── classes/
        ├── Funcionario.php
        ├── IMC.php
        ├── Pessoa.php
        └── Professor.php
```

## 📖 Tópicos Abordados

### Tópico 01: Revisão de POO em PHP
📋 **[Ver documentação completa e exemplos](topico01/revisao_poo_php/README.md)**


## 🛠️ Configuração do Ambiente de Desenvolvimento

#### PHP e Ambiente Laravel
* **Script da Documentação Oficial (mac/windows/linux)**: [Link](https://laravel.com/docs/12.x/installation#installing-php)


### Para Linux/Ubuntu

#### Instalação do PHP 8.4
* **Instalação do PHP8.4 no Ubuntu 24.04**: [Link](https://www.edivaldobrito.com.br/como-instalar-o-php-8-4-no-ubuntu-22-04-e-24-04-e-derivados/)

#### Instalação do Composer
* **Instalação do Composer no Linux**: [Link](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)

#### Terminal e Produtividade
* **Instalação do ZSH**: [Link](https://github.com/ohmyzsh/ohmyzsh/wiki/Installing-ZSH)
* **Oh My Zsh**: [Link](https://github.com/ohmyzsh/ohmyzsh)
* **Tutorial ZSH+Plugins+Power10k Theme no Ubuntu 22.04**: [Link](https://gist.github.com/jonilsonds9/4b017d54876b279c27ce77f116f5d3ca)
* **Power10K ZSH Theme**: [Link](https://github.com/romkatv/powerlevel10k)

#### Banco de Dados com Docker
* **Como criar um banco de dados MySQL**: [Link](https://nodejs.org/en/download)

### Para Windows

#### Ferramentas de Desenvolvimento
* **Composer para Windows**: [Link](https://getcomposer.org/doc/00-intro.md#installation-windows)
* **Tutorial OH-MY-POSH (Versão do ZSH para Windows PowerShell)**: [Link](https://prof-gillgonzales-ifsul.notion.site/Oh-My-Posh-2551037386bf8057a457f2564059dbe1)
* **Turbinando sua Produtividade: Autocomplete e Personalização no Terminal do Windows**: [Link](https://dev.to/devsnorte/turbinando-sua-produtividade-autocomplete-e-personalizacao-no-terminal-do-windows-39e9)

## 📋 Padrões de Codificação PHP (PSRs)

### Recursos Essenciais
* **PHP-FIG**: [Link](https://www.php-fig.org/psr/) - Grupo oficial de padronização do PHP
* **O que são as PSRs do PHP**: [Link](https://www.treinaweb.com.br/blog/o-que-sao-as-psrs-do-php)
* **PSR-1 - Padrões básicos de codificação do PHP**: [Link](https://www.treinaweb.com.br/blog/psr-1-conheca-os-padroes-basicos-de-codificacao-do-php/)
* **PSR-4 - Recomendação de autoload do PHP**: [Link](hhttps://www.treinaweb.com.br/blog/psr-4-a-recomendacao-de-autoload-do-php?gclid=EAIaIQobChMImunDpcnBgAMVUSrUAR3zKwKuEAAYASAAEgL3XPD_BwE)

## 🔧 Ferramentas de Desenvolvimento

### VSCode
* **Extensões para VSCode**: [Link](https://nodejs.org/en/download)

#### Extensões Recomendadas para PHP

1. **INTELEPHENSE** - IntelliSense avançado para PHP
   - ID: `bmewburn.vscode-intelephense-client`
   - Instalação: `ext install bmewburn.vscode-intelephense-client`

2. **COMPOSER** - Suporte ao gerenciador de dependências
   - ID: `composer-intelliphense`

3. **PHP DEBUG** - Depuração com Xdebug
   - ID: `xdebug.php-debug`
   - Instalação: `ext install xdebug.php-debug`

4. **CONSTRUTOR** - Geração automática de construtores
   - ID: `MehediDracula.php-constructor`
   - Instalação: `ext install MehediDracula.php-constructor`

5. **GETTER & SETTER** - Geração automática de getters e setters
   - ID: `phproberto.vscode-php-getters-setters`
   - Instalação: `ext install phproberto.vscode-php-getters-setters`

6. **LARAPHENSE** - IntelliSense específico para Laravel
   - ID: `ryannaddy.laravel-artisan`
   - Instalação: `ext install ryannaddy.laravel-artisan`

## 🤖 Versionamento de Código### Git

  * **Git vs SVN**: [Link](https://prof-gillgonzales-ifsul.notion.site/SVN-vs-GIT-2551037386bf80a4b26ec69429777850)
  * **Tutorial de Instalação do Git no Windows**: [Link](https://dicasdeprogramacao.com.br/como-instalar-o-git-no-windows/)
  * **Git e Github - Criação de projetos**: [Link](https://www.freecodecamp.org/portuguese/news/tutorial-de-git-e-github-controle-de-versao-para-iniciantes/)
  * **Git e GitLab - Criação de Projeto**: [Link](https://medium.com/ekode/primeiros-passos-com-git-e-gitlab-criando-seu-primeiro-projeto-89f9001614b0)
  * **Git por Linus Torvalds**: [Link](https://www.youtube.com/watch?v=4XpnKHJAok8)
  * **Git para iniciantes**: [Link](https://www.youtube.com/watch?v=8JJ101D3knE)
  * **Pro Git - Livro Gratuito**: [Link](https://git-scm.com/book/pt-br/v2)

### Configuração Inicial

 * **Uso de chaves SSH para acesso ao GitHub**:[Link](https://docs.github.com/pt/enterprise-cloud@latest/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent)

#### Configurando Chave SSH
```bash
git config core.sshCommand 'ssh -o IdentitiesOnly=yes -i ~/.ssh/NOME_DA_CHAVE -F /dev/null'
```

#### Instalação e Configuração
> **Nota para Windows:** Use a opção HTTPS "Windows Secure Channel library"

<!-- ## 🗄️ Banco de Dados com Docker

### MySQL e phpMyAdmin
* **phpmyAdminMysqlDockerCompose**: [Link](https://nodejs.org/en/download) -->


---

**Última atualização:** Agosto de 2025
