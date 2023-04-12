<?php

namespace App\Controller;

use App\Entity\Persone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\redirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('persone')]
class PersoneController extends AbstractController
{

    #[Route('/', name: 'persone.list')]
    public function index(ManagerRegistry $doctrine): Response
    {
      //on va recuperer la liste des utilisateurs
      $repository = $doctrine->getRepository(persistentObject: Persone::class);
      $persones = $repository->findAll();
      return $this->render('persone/index.html.twig', [
        'persones' => $persones
      ]);
    }
    #[Route('/alls/age/{ageMin}/{ageMax}', name: 'persone.list.age')]
    public function personesByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response
    {
      //on va recuperer la liste des utilisateurs
      $repository = $doctrine->getRepository(persistentObject: Persone::class);
      $persones = $repository->findPersonesByAgeInterval($ageMin, $ageMax);
      return $this->render('persone/index.html.twig', [
        'persones' => $persones
      ]);
    }
    #[Route('/stats/age/{ageMin}/{ageMax}', name: 'persone.list.age')]
    public function statsPersonesByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response
    {
      //on va recuperer la liste des utilisateurs
      $repository = $doctrine->getRepository(persistentObject: Persone::class);
      $stats = $repository->statsPersonesByAgeInterval($ageMin, $ageMax);
      return $this->render('persone/stats.html.twig', [
        'stats' => $stats[0],
        'ageMin' => $ageMin,
        'ageMax' => $ageMax
      ]);
    }

    #[Route('/alls/{page?1}/{nbre?12}', name: 'persone.list.alls')]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response
    {
      //on va recuperer la liste des utilisateurs
      $repository = $doctrine->getRepository(persistentObject: Persone::class);
      //conter les nombres des element dans le repository
      $nbPersone = $repository->count([]);
      
      $nbrePage = ceil(num: $nbPersone / $nbre);
      $persones = $repository->findBy([], [], $nbre, offset:($page-1)*$nbre);
      return $this->render('persone/index.html.twig', [
        'persones' => $persones,
        'isPaginated' => true,
        'nbrePage' => $nbrePage,
        'page' => $page,
        'nbre' => $nbre
      ]);
    }

    #[Route('/{id<\d+>}', name: 'persone.detail')]
    public function detail(ManagerRegistry $doctrine, $id): Response
    {
      //on va recuperer la liste des utilisateurs
      $repository = $doctrine->getRepository(persistentObject: Persone::class);
      $persone= $repository->find($id);
      if(!$persone) {
        $this->addFlash(type: 'error', message: "La personne d'id $id n'existe pas"); 
        return $this->redirectToRoute(route:'persone.list');
      }
      return $this->render('persone/detail.html.twig', [
        'persone' => $persone
      ]);
    }


    #[Route('/add', name: 'persone.add')]
    public function addPersone(ManagerRegistry $doctrine): Response

    {
        $entityManager = $doctrine->getManager();
        $persone = new Persone();
        $persone -> setFirstname(firstname: 'Da Silva');
        $persone -> setname(name: 'Ouridade');
        $persone -> setAge(age: '35');
       // $persone2 = new Persone();
       // $persone2 -> setFirstname(firstname: 'Dos Santos');
       // $persone2 -> setname(name: 'Dadiva');
       // $persone2 -> setAge(age: '12');
        //ajouter l'operation d'insertion de le persone dans ma transation
        $entityManager -> persist($persone);
       // $entityManager -> persist($persone2);
        //executer la transation todo
        $entityManager->flush();
        return $this->render('persone/detail.html.twig', [
            'persone' => $persone
        ]);
    }
    #[Route('/delete{id}', name: 'persone.delete')]
    public function deletePersone(Persone $persone = null, ManagerRegistry $doctrine): RedirectResponse
    {//récuperer la personne
      if ($persone) {
        // si la personne existe, la suprimer et returner un flashMessage de succès 
        $manager = $doctrine->getManager();
        //ajoute de la fonction de suprussion dans la transation
        $manager ->remove($persone);
        //executer la transation 
        $manager ->flush();
        $this->addFlash(type: 'success', message: 'La personne a été suprimer avec succès');
      } else {
        // sinon, retourner une message d'erreur
        $this->addFlash(type: 'error', message: 'Personne innexistente');
      }
      return $this -> redirectToRoute('persone.list.alls');
    } 
    #[Route('/update/{id}/{name}/{firstname}/{age}', name: 'persone.update')]
    public function updatePersone(Persone $persone = null, ManagerRegistry $doctrine, $name, $firstname, $age): RedirectResponse
    {// verifier la existence de la personne a mettre a jour
      if($persone){
        $persone->setName($name);
        $persone->setFirstname($firstname);
        $persone->setAge($age);
        $manager= $doctrine->getManager();
        $manager->persist($persone);
        $manager->flush();
        $this->addFlash(type: 'success', message: 'La personne a été mis à jour avec succès');
      } else {
        // sinon, retourner une message d'erreur
        $this->addFlash(type: 'error', message: 'Personne innexistente');
      }
      return $this -> redirectToRoute('persone.list.alls');
    }
}
