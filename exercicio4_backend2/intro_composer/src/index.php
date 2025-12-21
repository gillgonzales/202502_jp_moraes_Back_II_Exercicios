<?php
require "../vendor/autoload.php";
use Illuminate\Support\Str;
use Jpm\IntroComposer\classes\Medico;
use Jpm\IntroComposer\logs\Relatorio;
use Jpm\IntroComposer\classes\Atleta;

// classe abstrata serve como modelo base para construir outras classes ()

/**
 * 
 * 
 * Uma breve explicação sobre classes abstratas, interfaces e polimorfismo no PHP
 
 * ===============================================
 * CLASSE ABSTRATA vs INTERFACE - GUIA RÁPIDO
 * ===============================================
 * 
 * CLASSE ABSTRATA:
 * - Serve como "base comum" para classes similares (ex: 3 tipos de usuários)
 * - Pode ter métodos JÁ IMPLEMENTADOS (código reutilizável)
 * - Pode ter PROPRIEDADES ($nome, $email, etc)
 * - Pode ter métodos ABSTRATOS (força implementação nas filhas) ,os normais nao precisa ser reimplementados
 * - Uma classe só pode HERDAR de UMA classe abstrata (extends)
 * - Use quando: classes têm características SIMILARES e código COMUM
 


 * INTERFACE:
 * - É um "contrato" que define APENAS assinaturas de métodos
 * - NÃO pode ter implementações (só a partir PHP 8)
 * - NÃO pode ter propriedades (atributos)
 * - TODOS os métodos devem ser implementados
 * - Uma classe pode implementar MÚLTIPLAS interfaces (implements)
 * - Use quando: quer garantir que classes tenham determinados COMPORTAMENTOS
 * 
 * 
 * 
 * POLIMORFISMO = "Muitas formas"
 * 
 * 🎭 DEFINIÇÃO SIMPLES:
 * É a capacidade de um mesmo código funcionar com diferentes tipos de objetos - seria 
 * Mesma "interface", comportamentos diferentes - mesma funcao so que ela faz algo diferente pra cada objeto
 * 
 * É como um botão "REPRODUZIR":
 * - No Spotify → Toca música 🎵
 * - Na Netflix → Reproduz filme 🎬  
 * - No YouTube → Reproduz vídeo 📺
 * - No PowerPoint → Inicia apresentação 📊
 * 
 * mesmo botao ,acoes diferentes 
 * 
 * 🎯 NO PHP:
 * - Mesmo método, implementações diferentes
 * - Uma variável pode receber diferentes tipos de objeto
 * - O método correto é chamado automaticamente
 **/

//implementando o uso de Traits no PHP
echo "<pre>";
$atleta = new Atleta("João Silva", 25, 1.75, 60);
echo $atleta;


//implementando interface iFuncionario (usando classe Medico)

$medico = new Medico("Paulo Paixão", 12345, "Fisiologista", 15000, 1.9, 65);
$jogador = new Atleta("Pedro Geromel", 19, 1.84,60);

$relatorio = new Relatorio;
$relatorio->add($medico);
$relatorio->add($jogador);
$relatorio->imprime();


$texto = "ESTE TEXTO ESTÁ EM MAIÚSCULO";
$resultado = Str::lower($texto);
echo $resultado; 

// var_dump($dotenv);

echo "<hr>";

//var_dump($_ENV['SECRET_KEY']);