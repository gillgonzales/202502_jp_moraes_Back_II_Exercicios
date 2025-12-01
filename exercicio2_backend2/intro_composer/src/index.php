<?php
require "../vendor/autoload.php";
use Illuminate\Support\Str;


// echo __DIR__;
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
//$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
//$dotenv->load();

$texto = "ESTE TEXTO ESTÁ EM MAIÚSCULO";
$resultado = Str::lower($texto);
echo $resultado; 

// var_dump($dotenv);

echo "<hr>";

//var_dump($_ENV['SECRET_KEY']);