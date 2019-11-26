<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/author/insert", name="author_insert")
     */
    public function insertAuthor(EntityManagerInterface $entityManager){
        $author = new Author();
        $author->setFirstname('Florian');
        $author->setName('Soumaille');
        $author->setBirthDate(new \DateTime('03/04/1986'));
        $author->setBiographie('Je suis Flo, le beau et le plus fort, bla bla bla...');

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->render('author.recuSQL.html.twig', [
            'author' => $author,

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

        return $this->render('finder.authors.html.twig', [
            'found' => $authors
        ]);

    }

}
