<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'etudiant.all')]
    public function index(ManagerRegistry $doctrine): Response

    {
        $repository=$doctrine->getRepository(Etudiant::class);
        $etudiants=$repository->findAll(); 

        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }

    #[Route('/etudiant/edit/{id?0} ', name: 'etudiant.add')]
    public function addEtudiant(ManagerRegistry $doctrine , Request $request, Etudiant $etudiant=null): Response
    {
      
        if (!$etudiant){
            $etudiant = new Etudiant();
        }

        $form=$this->createForm(EtudiantType::class , $etudiant); 
        $form->handleRequest($request);
        if($form->isSubmitted()){ 
            //$form->getData()
            $entityManager = $doctrine->getManager(); 
            $entityManager->persist($etudiant);

            $entityManager->flush();
            $this->addFlash("success","Etudiant added ");
            return $this->redirectToRoute('etudiant.all');
            

        }else{
            return $this->render('etudiant/add.html.twig', [
                'form' => $form->createView(),
            ]);


         
    }
}

#[Route('/etudiant/remove/{id?0} ', name: 'etudiant.remove')]
public function remove(ManagerRegistry $doctrine , Etudiant $etudiant = null  ){
    if ($etudiant ==null){
        $this->addFlash('error','Etudiant not found'); 
        return ($this->redirectToRoute('etudiant.all'));

    }else {
        $manager=$doctrine->getManager(); 
        //ajout la fonction de suppression dans la transaction 
        $manager->remove($etudiant);
        //excecuter la transaction 
        $manager->flush();
        $s=$etudiant->getNom();
        $this->addFlash('success', " $s successfully removed "); 
        return ($this->redirectToRoute('etudiant.all'));

    } 

}

}
