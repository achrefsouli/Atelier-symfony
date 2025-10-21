<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service')]
    public function showService ($name){
        return $this->render('service/showService.html.twig', [
            'controller_name' => 'ServiceController',
            'name'=> $name,
        ]);
    }
    public function goToIndex(){
        return $this->redirectToRoute('app_index');
    }
}
