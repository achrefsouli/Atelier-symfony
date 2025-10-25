<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddBookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/allbooks', name: 'app_allbooks')]
    public function getAuthors(BookRepository $repo,Request $req){
        
       
            $books = $repo->findAll();
        //$books=$repo->findbyCategory("romance");

        return $this->render('book/index.html.twig', [
            'books' => $books,
            
        ]);

    }
    #[Route('/addbook', name: 'app_book')]
    public function addBook(EntityManagerInterface $mr, Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(AddBookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mr->persist($book);
            $mr->flush();
        }

        return $this->render('book/addBook.html.twig', [
            'controller_name' => 'BookController',
            'bookForm' => $form,
        ]);
    }
    #[Route('/updatebook/{id}', name: 'app_updatebook')]
    public function updateBook(EntityManagerInterface $mr, Request $request, $id)
    {
        $book = new Book();
        $book = $mr->getRepository(Book::class)->find($id);
        $form = $this->createForm(AddBookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mr->persist($book);
            $mr->flush();
            return $this->redirectToRoute("app_allbooks");
        }
        
        return $this->render('book/addBook.html.twig', [
            'controller_name' => 'BookController',
            'bookForm' => $form,
        ]);
    }
    #[Route('/deletebook/{id}', name: 'app_deletebook')]
    public function deleteBook(EntityManagerInterface $mr, Request $request, $id)
    {
        $book = new Book();
        $book = $mr->getRepository(Book::class)->find($id);
        $mr->remove($book);
        $mr->flush();
        return $this->redirectToRoute("app_allbooks");
    }
}
