<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author", name="author_list")
     */
    public function author(AuthorRepository $authorRepository)
    {
        $author = $authorRepository->findAll();

        return $this->render('author.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route ("/author/{id}", name="author")
     */
    public function authorShow(AuthorRepository $authorRepository, $id){

        $author = $authorRepository->find($id);

        return $this->render('show_author.html.twig', [
            'author' => $author
        ] );
    }

    /**
     * @Route("/author_bio/{word}", name="author_bio")
     */
    public function authorByBio(AuthorRepository $authorRepository, $word)
    {
        // $authorRepository contient une instance de la classe 'AuthorRepository'
        // generalement on obtient l'instance de classe (ou un objet) en utilisant le mot clé "new"
        // grace a symfony on obtient l'instance de la classe repository en la passant simplement en parametre
        $authors = $authorRepository->getAuthorByBio($word);

        //

        return $this->render('finder.authors.html.twig', [
            'found' => $authors
        ]);

    }

}
