<?php
namespace Jpm\IntroComposer\classes; //isso aqui serve para definir o namespace da classe, 
// ajudando a organizar o código e evitar conflitos de nomes com outras classes em projetos maiores.

class Pessoa
{
    public string $nome;
    public int | null $idade;
    public float | null $peso;
    public float | null $altura;

    public function __construct($nome, $idade, $peso=null, $altura=null)
    {
        $this->nome = $nome;
        $this->idade = $idade;
        $this->peso = $peso;
        $this->altura = $altura;
    }

    public function __destruct()
    {
        echo "\n$this->nome foi destruído!!!";
    }

    function __get($name){
        echo "\nRetornando o $name do $this->nome...";
        return $this->$name;
    }

    function __set($name,$value){
        echo "\nAlterando $name do $this->nome...\n";
        $this->$name=$value;
    }

    function __toString(): string{
        return "\n===Dados da Pessoa==="
                ."\nNome: $this->nome"
                .($this->idade?"\nIdade: $this->idade":"")
                ."\nPessoa: $this->peso"
                ."\nAltura: $this->altura";
    }
}
