<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->has(name:'nbVisite')) {
            $nbVisite = $session->get(name:'nbVisite') + 1;
           
            }else{
                $nbVisite = 1;
            }
        $session->set('nbVisite', $nbVisite);
        return $this->render(view: 'session/index.html.twig',);
    }
}
