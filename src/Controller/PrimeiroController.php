<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrimeiroController extends AbstractController
{
    
   
    #[Route('/template', name: 'template')]
    public function template(): Response
    {
    
        return $this->render(view: 'template.html.twig');
    }    
     
    #[Route('/sayHellow/{name?test}/{firstname?test}', name: 'say.Hellow')]
    public function sayHellow($name, $firstname): Response
   {
    
       return $this->render(view: 'primeiro/hellow.html.twig', parameters: [
            'nom' => $name,
             'prenom' => $firstname,

        ]);

     
       
        
  }
}

   