<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersoneController extends AbstractController
{
    #[Route('/persone', name: 'app_persone')]
    public function index(): Response
    {
        return $this->render('persone/index.html.twig', [
            'controller_name' => 'PersoneController',
        ]);
    }
}
