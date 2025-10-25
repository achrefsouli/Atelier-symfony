<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AddAuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/all', name: 'app_allAuthor')]
    public function getAuthors(AuthorRepository $repo,Request $req){
        
       
            $authors = $repo->findAll();
        

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
            
        ]);

    }
    #[Route('/addauthor', name: 'app_addAuthor')]
    public function addAuthor(EntityManagerInterface $mr){
    $author=new Author();
    $author->setUsername("rayen");
    $author->setEmail("rayen@gmail.com");
    $mr->persist($author);
    $mr->flush();
    return $this->redirectToRoute("app_allAuthor");

    }
    #[Route('/addauthorform', name: 'app_addAuthorForm')]
    public function addAuthorform(EntityManagerInterface $mr,Request $req){
        $author = new Author();
        $form=$this->createForm(AddAuthorType::class,$author);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $mr->persist($author); 
            $mr->flush(); 

            return $this->redirectToRoute('app_allAuthor');
        }
        return $this->render('author/form.html.twig', [
            'authorForm' => $form,
        ]);
    }
    #[Route('/details/{id}', name: 'author_detailAuthor')]
    public function getAuthor(AuthorRepository  $authRepo, $id): Response
    {
        return $this->render('author/showAuthor.html.twig', [
            'authors' => $authRepo->find($id),
        ]);
    }
    #[Route('/update/{id}', name: 'author_updateAuthor')]
    public function updateAuthor(EntityManagerInterface $mr, Request $request, $id): Response
    {
        $author = new Author();

        
        $author = $mr->getRepository(Author::class)->find($id);
        $form = $this->createForm(AddAuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $mr->persist($author);
            $mr->flush();

            return $this->redirectToRoute('app_allAuthor');
        }

        return $this->render('author/form.html.twig', [
            'authorForm' => $form,
        ]);
    }

    //delete author
    #[Route('/delete/{id}', name: 'author_delete')]
    public function delete(EntityManagerInterface $mr, $id): Response
    {
        $author = $mr->getRepository(Author::class)->find($id);
        $mr->remove($author);
        $mr->flush();

        return $this->redirectToRoute('app_allAuthor');
    }

}
