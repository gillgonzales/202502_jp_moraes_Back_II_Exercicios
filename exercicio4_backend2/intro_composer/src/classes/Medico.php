<?php
namespace Jpm\IntroComposer\classes;

use Exception;

use Jpm\IntroComposer\classes\Pessoa;
use Jpm\IntroComposer\interfaces\IMC;
use Jpm\IntroComposer\interfaces\Funcionario;

class Medico extends Pessoa implements IMC, Funcionario{

	private $CRM, $especialidade, $imc, $salario ,$tempoContrato;

	public function __construct($nome, $crm, $especialidade, $salario, $tempoContrato, $idade=null, $altura=1, $peso=1)
{
    $this->nome = $nome;
    $this->CRM = $crm;
    $this->especialidade = $especialidade;
    $this->salario = $salario;
    $this->tempoContrato = $tempoContrato;
    $this->idade = $idade;
    $this->peso = $peso;
    $this->altura = $altura;
    $this->calcImc();
}

	public function getCRM(){
		return $this->CRM;
	}

	public function calcImc():void 
	{
		try {
			if(isset($this->peso)&&isset($this->altura)) {
				$this->imc = $this->peso/$this->altura**2;		
			} else{
				throw new Exception("Erro, defina peso e altura primeiro!");
			}
		} catch (Exception $error) {
			echo $error->getMessage();
			foreach($error->getTrace() as $trace)
				 print_r($trace);
			throw $error;
		}
	}

	public function showImc():void
	{
		if(is_numeric($this->imc))
			echo "\nO IMC do Médico $this->nome é: " . number_format($this->imc, 2) . "\n";
	}

	public function mostrarSalario(): string
	{

		return "Salário: R$ " . number_format($this->salario, 2, ',', '.');


	}
    public function mostrarTempoContrato(): string
	{

		return "Contrato de " . $this->tempoContrato . " anos.";

	}


	public function __toString(): string
	{
		$className = self::class;
		return 	"\n=== Dados de $className ==="
			. "\nHerança: ".parent::class
			. "\nAtributos:"
			. "\nIMC: ".$this->imc
			. "\n\tNome: $this->nome"
			. ($this->idade ? "\n\tIdade: $this->idade" : "")
			. "\n\tEspecialidade: $this->especialidade"
			. "\n\tCRM: $this->CRM\n";
	}
}