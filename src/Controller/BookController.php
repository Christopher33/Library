<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    /**
     * @Route("/book", name="book_list")
     */
    public function book(BookRepository $bookRepository)
    {
        $book = $bookRepository->findAll();

        return $this->render('book.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route ("/book/{id}", name="book")
     */
    public function bookShow(BookRepository $bookRepository, $id)
    {

        $book = $bookRepository->find($id);

        return $this->render('show_book.html.twig', [
            'book' => $book
        ] );
    }

    /**
     * @Route("/books_by_genre", name="books_by_genre")
     */
    public function getBooksByGenre(BookRepository $bookRepository)
    {
        $books = $bookRepository->getBooksByGenre();

        dump($books); die();

        // Appelle le bookRepository (en le passant en parametre de la methode)
        // Appellle la methode qu'on a cr"ee dans le book Repository ("getByGenre()")
        // Cette méthode est censée nous retourner tous les livres en fonction d'un genre
        // Elle va donc executer une requete SELECT en base de données
    }

}
