<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    private $authors=array();
    public function __construct() {
       $this->authors = array(
           array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
           array('id' => 2, 'picture' => '/images/william-shakespeare.jpeg', 'username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200),
           array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
       );
   }
   
   
    #[Route('/showAuthor/{name}', name: 'app_showAuthor')]
    public function showAuthor($name){
        return $this->render('author/show.html.twig', [
            'controller_name' => 'AuthorController',
            'name'=>$name,
        ]);
    }
    #[Route('/list', name: 'app_listAuthor')]
    public function listAuthors(){
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpeg', 'username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );
        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }
    #[Route('/authorDetails/{id}', name: 'app_detailsAuthor')]
    public function authorDetails($id){
        return $this->render('author/showAuthor.html.twig', [
            'controller_name' => 'AuthorController',
            'authors'=> $this->authors ,
            'id'=>$id,
            
        ]);
    }
}
