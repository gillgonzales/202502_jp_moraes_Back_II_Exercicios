<?php 

class Pessoa {
	private float $imc;

	function __construct(
		public string $nome,
		public int $idade,
		protected float $peso = 0,
		protected float $altura = 0,
	) {
		echo "\nObjeto $this->nome construído!!!";
	}

	function __destruct()
	{
		echo "\n$this->nome foi destruído!!";
	}

	function calcIMC(){
		if(!$this->peso && !$this->altura){
			echo "\nErro: configurar peso e altura do $this->nome !!\n";
			$this->imc = 0;
			return;
		}
		$this->imc = $this->peso/$this->altura**2;
	}

	function getImc(){
		return $this->imc;
	}

	function __get($nomeAtributo){//imc
		var_dump($nomeAtributo);
		return $this->$nomeAtributo; //imc ($this->imc)
	}

	function setPeso(float $peso): void
	{
		$this->peso = $peso;
	}

	function setAltura(float $altura): void
	{
		$this->altura = $altura;
	}
}

$pessoaUm = new Pessoa("Gill",36);
$pessoaDois = new Pessoa("Vera",60,89,1.55);

$pessoaUm->setAltura(1.75); //protected
$pessoaUm->setPeso(68);

$pessoaUm->calcIMC();
$pessoaDois->calcIMC();


echo "\nO IMC do $pessoaDois->nome eh ".number_format($pessoaDois->getImc(),2)." \n";

echo "\nIMC do $pessoaUm->nome: ".number_format($pessoaUm->getImc(),2)."\n";

echo "$pessoaUm->nome possui $pessoaUm->peso kg e $pessoaUm->altura m de altura com $pessoaUm->imc IMC\n";

var_dump($pessoaUm, $pessoaDois);