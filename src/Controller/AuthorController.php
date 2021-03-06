<?php

namespace App\Controller;

use App\BusinessLogic\Domain\Command\CreateAuthor;
use App\BusinessLogic\Domain\Command\DeleteAuthor;
use App\BusinessLogic\Domain\Command\UpdateAuthor;
use App\Entity\Author;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for Author actions
 *
 * @package App\Controller
 * @author davamigo@gmail.com
 * @Route("/author")
 */
class AuthorController extends Controller
{
    /**
     * Author default controller action - shows the authors list
     *
     * @return Response
     * @Route("/", name="author_index", methods={"GET"})
     */
    public function index()
    {
        /** @var Author[] $authors */
        $authors = $this->getDoctrine()->getRepository(Author::class)->findAll();

        return $this->render('Author/index.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * Insert author controller action - inserts an author
     *
     * @param Request $request
     * @return Response
     * @Route("/insert", name="author_insert", methods={"GET"})
     * @Route("/", name="author_post", methods={"POST"})
     */
    public function insert(Request $request)
    {
        /** @var Author $author */
        $author = new Author();

        $formOptions = [
            'action' => $this->generateUrl('author_post'),
            'method' => 'POST',
            'validation_groups' => 'insert'
        ];

        $dateOptions = [
            'required'  => false,
            'widget'    => 'single_text',
            'format'    => 'yyyy-MM-dd'
        ];

        $form = $this->createFormBuilder($author, $formOptions)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('bornDate', DateType::class, $dateOptions)
            ->add('diedDate', DateType::class, $dateOptions)
            ->add('insert', SubmitType::class, array('label' => 'Insert Author'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $commandBus = $this->get('event_sourcing.command_bus');
            $commandBus->addCommand(new CreateAuthor($author->toDomainEntity()));

            return $this->redirectToRoute('author_index');
        }

        return $this->render('Author/insert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Update author controller action - updates an author
     *
     * @param string  $uuid
     * @param Request $request
     * @return Response
     * @Route("/{uuid}/edit", name="author_edit", methods={"GET"})
     * @Route("/{uuid}", name="author_put", methods={"PUT"})
     */
    public function update($uuid, Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Author $author */
        $author = $em->getRepository(Author::class)->find($uuid);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id ' . $uuid);
        }

        $formOptions = [
            'action' => $this->generateUrl('author_put', [ 'uuid' => $uuid ]),
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

        $form = $this->createFormBuilder($author, $formOptions)
            ->add('uuid', TextType::class, $uuidOptions)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('bornDate', DateType::class, $dateOptions)
            ->add('diedDate', DateType::class, $dateOptions)
            ->add('update', SubmitType::class, array('label' => 'Update Author'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $commandBus = $this->get('event_sourcing.command_bus');
            $commandBus->addCommand(new UpdateAuthor($author->toDomainEntity()));

            return $this->redirectToRoute('author_index');
        }

        return $this->render('Author/update.html.twig', [
            'form'   => $form->createView(),
            'author' => $author
        ]);
    }

    /**
     * Delete author controller action - deletes an author
     *
     * @param string  $uuid
     * @param Request $request
     * @return Response
     * @Route("/{uuid}/delete", name="author_remove", methods={"GET"})
     * @Route("/{uuid}", name="author_delete", methods={"DELETE"})
     */
    public function delete($uuid, Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Author $author */
        $author = $em->getRepository(Author::class)->find($uuid);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id ' . $uuid);
        }

        $disabledOptions = [
            'disabled' => true
        ];

        $formOptions = [
            'action' => $this->generateUrl('author_delete', [ 'uuid' => $uuid ]),
            'method' => 'DELETE',
            'validation_groups' => 'delete'
        ];

        $form = $this->createFormBuilder($author, $formOptions)
            ->add('uuid', TextType::class, $disabledOptions)
            ->add('firstName', TextType::class, $disabledOptions)
            ->add('lastName', TextType::class, $disabledOptions)
            ->add('delete', SubmitType::class, array('label' => 'Delete Author'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $commandBus = $this->get('event_sourcing.command_bus');
            $commandBus->addCommand(new DeleteAuthor($author->toDomainEntity()));

            return $this->redirectToRoute('author_index');
        }

        return $this->render('Author/delete.html.twig', [
            'form'   => $form->createView(),
            'author' => $author
        ]);
    }
}
