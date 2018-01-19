<?php

namespace App\Controller;

use App\BusinessLogic\Domain\Command\CreateBook;
use App\BusinessLogic\Domain\Command\UpdateBook;
use App\Entity\Book;
use App\Entity\Publisher;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for Book actions
 *
 * @package App\Controller
 * @Route("/book")
 */
class BookController extends Controller
{
    /**
     * Book default controller action - shows the books list
     *
     * @return Response
     * @Route("/", name="book_index", methods={"GET"})
     */
    public function index()
    {
        /** @var Book[] $books */
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->render('Book/index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * Insert book controller action - inserts an book
     *
     * @param Request $request
     * @return Response
     * @Route("/insert", name="book_insert", methods={"GET"})
     * @Route("/", name="book_post", methods={"POST"})
     */
    public function insert(Request $request)
    {
        /** @var Book $book */
        $book = new Book();

        $formOptions = [
            'action' => $this->generateUrl('book_post'),
            'method' => 'POST',
            'validation_groups' => 'insert'
        ];

        $dateOptions = [
            'required'  => false,
            'widget'    => 'single_text',
            'format'    => 'yyyy-MM-dd'
        ];

        $publisherOptions = [
            'required'  => false,
            'class' => Publisher::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false
        ];

        $form = $this->createFormBuilder($book, $formOptions)
            ->add('name', TextType::class)
            ->add('releaseDate', DateType::class, $dateOptions)
            ->add('publisher', EntityType::class, $publisherOptions)
            ->add('insert', SubmitType::class, array('label' => 'Insert Book'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $commandBus = $this->get('event_sourcing.command_bus');
            $commandBus->addCommand(new CreateBook($book->toDomainEntity()));

            return $this->redirectToRoute('book_index');
        }

        return $this->render('Book/insert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Update book controller action - updates an book
     *
     * @param string  $uuid
     * @param Request $request
     * @return Response
     * @Route("/{uuid}/edit", name="book_edit", methods={"GET"})
     * @Route("/{uuid}", name="book_put", methods={"PUT"})
     */
    public function update($uuid, Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Book $book */
        $book = $em->getRepository(Book::class)->find($uuid);
        if (!$book) {
            throw $this->createNotFoundException('No book found for id ' . $uuid);
        }

        $formOptions = [
            'action' => $this->generateUrl('book_put', [ 'uuid' => $uuid ]),
            'method' => 'PUT',
            'validation_groups' => 'update'
        ];

        $uuidOptions = [
            'disabled' => true
        ];

        $dateOptions = [
            'required'  => false,
            'widget'    => 'single_text',
            'format'    => 'yyyy-MM-dd'
        ];

        $publisherOptions = [
            'required'  => false,
            'class' => Publisher::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false
        ];

        $form = $this->createFormBuilder($book, $formOptions)
            ->add('uuid', TextType::class, $uuidOptions)
            ->add('name', TextType::class)
            ->add('releaseDate', DateType::class, $dateOptions)
            ->add('publisher', EntityType::class, $publisherOptions)
            ->add('update', SubmitType::class, array('label' => 'Update Book'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $commandBus = $this->get('event_sourcing.command_bus');
            $commandBus->addCommand(new UpdateBook($book->toDomainEntity()));

            return $this->redirectToRoute('book_index');
        }

        return $this->render('Book/update.html.twig', [
            'form'   => $form->createView(),
            'book' => $book
        ]);
    }
}
