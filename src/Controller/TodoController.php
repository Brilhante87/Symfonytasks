<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
#[Route('/todo')]
class TodoController extends AbstractController
{
    
     

   #[Route( name: 'todo')]
       public function index(Request $request): Response
    {
        $session= $request->getSession();
        //afficher notre tableau de todo
       // sinon, je l'initialise puis j'affiche
        if(!$session->has(name: 'todos')){
            $todos = [
                'achat' => 'acheter cle usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash( type: 'info', message: "La liste des todos vies d'étre initialiée" );
        }    
        return $this->render(view:'todo/index.html.twig');
       
    }
     //ADD
   #[Route('/add/{name}/{content?test}', name: 'todo.add')]
    public function addTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        //verifier si j'ai mon tableau de todo dans la session
        if ($session->has(name: 'todos')){
           //si oui
           //verifier si on a déjà un todo evec le meme nom
           $todos = $session->get(name: 'todos');
           if (isset($todos[$name])){
            //si oui, afficher erreur
            $this->addFlash( type: 'error', message: "Le todo d'id $name existe déjà dans la liste" );
            } else {
                // si non, on l'ajoute et on affiche un messsage de succés
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash( type: 'success', message: "Le todo d'id $name a été ajouter avec succès" );
                
            }
        
        } else {
            //si non 
            //afficher une erreur et on va rediriger ver le controller index
            $this->addFlash( type: 'error', message: "La liste des todos n'est pas encore initialiée" );
           
        }
        return $this->redirectToRoute(route: 'todo');

    }
    // UPDATE
    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        //verifier si j'ai mon tableau de todo dans la session
        if ($session->has(name: 'todos')){
           //si oui
           //verifier si on a déjà un todo evec le meme nom
           $todos = $session->get(name: 'todos');
           if (!isset($todos[$name])){
            //si oui, afficher erreur
            $this->addFlash( type: 'error', message: "Le todo d'id $name n'existe pas dans la liste" );
            } else {
                // si non, on l'ajoute et on affiche un messsage de succés
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash( type: 'success', message: "Le todo d'id $name a été modifié avec succès" );
                
            }
        
        } else {
            //si non 
            //afficher une erreur et on va rediriger ver le controller index
            $this->addFlash( type: 'error', message: "La liste des todos n'est pas encore initialiée" );
           
        }
        return $this->redirectToRoute(route: 'todo');

    }
    // DELETE
    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name,): RedirectResponse{
         $session = $request->getSession();
         //verifier si j'ai mon tableau de todo dans la session
         if ($session->has(name: 'todos')){
            //si oui
            //verifier si on a déjà un todo evec le meme nom
            $todos = $session->get(name: 'todos');
            if (!isset($todos[$name])){
             //si oui, afficher erreur
             $this->addFlash( type: 'error', message: "Le todo d'id $name n'existe pas dans la liste" );
             } else {
                 // si non, on l'ajoute et on affiche un messsage de succés
                 unset($todos[$name]);
                 $session->set('todos', $todos);
                 $this->addFlash( type: 'success', message: "Le todo d'id $name a été suprimé avec succès" );
                 
             }
         
         } else {
             //si non 
             //afficher une erreur et on va rediriger ver le controller index
             $this->addFlash( type: 'error', message: "La liste des todos n'est pas encore initialiée" );
            
         }
         return $this->redirectToRoute(route: 'todo');
    }
    // RESET
    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse{
         $session = $request->getSession();
        $session->remove(name: 'todos');
         return $this->redirectToRoute(route: 'todo');
    }
    #[Route('/multi/{int1<\d+>}/{int2<\d+>}', name: 'todo.multi')]
    public function multiTodo($int1, $int2){
        $resultat= $int1 * $int2;
        return new response(content:"<h1>$resultat</h1>");
    }
}

