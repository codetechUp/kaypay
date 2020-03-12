<?php

namespace App\Controller;

use App\Entity\Depots;
use App\Algorithm\Algorithm;
use App\Entity\Affectations;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Config\Definition\Exception\Exception;



class AffecteController
{
   

    public function __invoke(Affectations $data):Affectations
    {
        
        
       return $data;
    }
}