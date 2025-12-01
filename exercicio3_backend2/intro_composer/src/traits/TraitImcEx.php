<?php

namespace Jpm\IntroComposer\traits;

trait TraitImcEx
{
    protected float | null $imc;
    
    public function calcIMC(): void
    {
        if(isset($this->peso)&&isset($this->altura)) {
            $this->imc = $this->peso/$this->altura**2;
        } else {
            echo "Erro, defina peso e altura primeiro!";
        }
    }
}