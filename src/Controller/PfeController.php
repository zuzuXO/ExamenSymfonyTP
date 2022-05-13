<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Pfe;
use App\Form\PfeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;
use Symfony\Component\Routing\Annotation\Route;

class PfeController extends AbstractController
{
    #[Route('/pfe', name: 'app_pfe')]
    public function index(): Response
    {
        return $this->render('pfe/index.html.twig', [
            'controller_name' => 'PfeController',
        ]);
    }
    #[Route('/Addpfe', name: 'app_pfe')]
    public function addPfe(Request $request,ManagerRegistry $doctrine):Response{
        $entityManager = $doctrine->getManager();
        $pfe=new Pfe();
        $form=$this->createForm(PfeType::class,$pfe);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $entityManager->persist($pfe);
            $entityManager->flush();
            $this->addFlash('success',"pfe ajouté avec succés! ");
            return $this->render('pfe/pfeAdded.html.twig',[
                'pfe'=> $pfe
            ]);
        }
        else {
            return $this->render('pfe/addPfe.html.twig',[
                'form'=> $form->createView()
            ]);
        }
    }
    #[Route('/template', name: 'temp')]
    public function temp():Response{
        return $this->render('template.html.twig');
    }
    #[Route('/entreprise/all', name: 'entreprise.view')]
    public function view(ManagerRegistry $doctrine):Response{
        $repository=$doctrine->getRepository(Entreprise::class);
        $entreprises=$repository->findAll();
        return $this->render('pfe/allpfe.html.twig',['entreprises'=>$entreprises]);
    }
    #[Route('/entreprise/{id<\d+>}',name:'details')]
    public function AfficheDetails (Entreprise $entreprise):Response{
        if (!$entreprise){
            $this->addFlash('error',"l'entreprise n'existe pas");
            return $this->redirectToRoute('pfe/allpfe.html.twig');
        }
        return $this->render('/pfe/entrepriseDetails.html.twig',[
            'entreprise'=>$entreprise
        ]);
    }
//    public function AfficheDetailsPfe($pfe):Response{
//        if(!$pfe){
//            $this->addFlash('error',"Ce pfe n'existe pas");
//            return $this->redirectToRoute('/pfe/entrepriseDetails.html.twig');
//        }
//        return $this->render('/pfe/detailPfe',[
//            'pfe'=>$pfe
//        ])
//    }
}
