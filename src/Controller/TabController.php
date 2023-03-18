<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes = [];
        for ($i = 0; $i < $nb; $i++) {
            $notes[] = rand(0, 20);
        }    
    
        return $this->render(view:'tab/index.html.twig', parameters: [
             'notes' => $notes
             ]);
    }
    #[Route('/tab/{users?test}', name: 'tab.users')]
    public function users(): Response
    {
        $users = [
            ['firstname' => 'aymen', 'name' => 'selaouti', 'age' => 39],
            ['firstname' => 'Mary', 'name' => 'selaouti', 'age' => 26],
            ['firstname' => 'jully', 'name' => 'selaouti', 'age' => 59]
           
        ];
        return $this->render(view:'tab/users.html.twig', parameters: [
             'users' => $users
             ]);
    }
}
