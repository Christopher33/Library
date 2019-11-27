<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route("/book/insert", name="book_insert")
     */

    public function insertBook (EntityManagerInterface $entityManager)
    {
        // insérer dans la table book un nouveau livre
        $book = new Book();
        $book->setTitle('Ca');
        $book->setStyle('Thriller');
        $book->setStock(true);
        $book->setNbpages(357);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render('recuSQL.html.twig', [
                'book' => $book,

            ]);
    }

    /**
     * @Route("/book/delete/{id}", name="book_delete")
     */
    public function deleteBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
            // je recupère un enregistrement book en BDD grace au repository de book
            $book = $bookRepository->find($id);

            //j'utilise l'entity manager avec la méthode remove pour enregistrer
            //la suppression du book dans l'unité du travail
            $entityManager->remove($book);
            // je valide la suppression en BDD avec la méthode flush
            $entityManager->flush();

            return $this->redirectToRoute('book.html.twig', [
                'book' => $book
            ]);
    }

    /**
     * @Route("/book/update/{id}", name="book_update")
     */
    public function updateBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        // j'utilise le Repository de l'entité Book pour recuperer un livre en fonction de son ID
        $book = $bookRepository->find($id);

        $book->setTitle('La fête du slip');

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_list');
    }

    /**
     * @Route("/book/form", name="book_form")
     */
    public function insertBookFrom()
    {
        // J'utilise le gabarit de formulaire pour créer mon formulaire
        // j'envoie mon formulaire à un fichier twig
        // et je l'affiche

        // je crée un nouveau Book,
        // en créant une nouvelle instance de l'entité Book
        $book = new Book();

        // J'utilise la méthode createForm pour créer le gabarit / le constructeur de
        // formulaire pour le Book : BookType (que j'ai généré en ligne de commandes)
        // Et je lui associe mon entité Book vide
        $bookForm = $this->createForm(BookType::class, $book);

        // à partir de mon gabarit, je crée la vue de mon formulaire
        $bookFormView = $bookForm->createView();

        // je retourne un fichier twig, et je lui envoie ma variable qui contient
        // mon formulaire
        return $this->render('book_form.html.twig', [
            'bookFormView' => $bookFormView
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





}
