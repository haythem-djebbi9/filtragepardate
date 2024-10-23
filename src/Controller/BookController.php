<?php

namespace App\Controller;
use App\Form\DateFilterType;  // Le formulaire de filtrage par date

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
   
    #[Route("/book/get/all",name:'app_book_getall')]
    public function getAllBooks(BookRepository $repo, Request $request): Response
    {
        // Créer le formulaire de filtrage par date
        $form = $this->createForm(DateFilterType::class);
        $form->handleRequest($request);
    
        $books = $repo->findAll(); // Par défaut, récupérer tous les livres
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data['startDate'];
            $endDate = $data['endDate'];
    
            // Filtrer les livres par plage de dates
            $books = $repo->findByPublicationDateRange($startDate, $endDate);
        }
    
        return $this->render('book/listbooks.html.twig', [
            'books' => $books,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/book/update/{id}',name:'app_book_update')]
    public function updatebook(EntityManagerInterface $em,$id
    ,bookRepository $repo){
        $book = $repo->find($id);
        $book->setTitle('book updated');
        $em->flush();
        return $this->redirectToRoute('app_book_getall');
    }

     #[Route('/book/delete/{id}',name:'app_book_delete')]
    public function deletebook(ManagerRegistry $manager,$id
    ,bookRepository $repo){
        $book = $repo->find($id);
        $em=$manager->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('app_book_getall');
    }
}
