<?php

namespace App\Controller;

use App\BusinessLogic\Domain\Command\CreatePublisher;
use App\Entity\Publisher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for Publisher actions
 *
 * @package App\Controller
 * @Route("/publisher")
 */
class PublisherController extends Controller
{
    /**
     * Publisher default controller action - shows the publishers list
     *
     * @return Response
     * @Route("/", name="publisher_index", methods={"GET"})
     */
    public function index()
    {
        /** @var Publisher[] $publishers */
        $publishers = $this->getDoctrine()->getRepository(Publisher::class)->findAll();

        return $this->render('Publisher/index.html.twig', [
            'publishers' => $publishers
        ]);
    }

    /**
     * Insert publisher controller action - inserts an publisher
     *
     * @param Request $request
     * @return Response
     * @Route("/insert", name="publisher_insert", methods={"GET"})
     * @Route("/", name="publisher_post", methods={"POST"})
     */
    public function insert(Request $request)
    {
        /** @var Publisher $publisher */
        $publisher = new Publisher();

        $formOptions = [
            'action' => $this->generateUrl('publisher_post'),
            'method' => 'POST',
            'validation_groups' => 'insert'
        ];

        $form = $this->createFormBuilder($publisher, $formOptions)
            ->add('name', TextType::class)
            ->add('insert', SubmitType::class, array('label' => 'Insert Publisher'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publisher = $form->getData();

            $commandBus = $this->get('event_sourcing.command_bus');
            $commandBus->addCommand(new CreatePublisher($publisher->toDomainEntity()));

            return $this->redirectToRoute('publisher_index');
        }

        return $this->render('Publisher/insert.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
