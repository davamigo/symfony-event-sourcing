<?php

namespace App\Controller;

use App\BusinessLogic\Domain\Command\CreateAuthor;
use App\BusinessLogic\Domain\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default controller class
 *
 * @package App\Controller
 * @author davamigo@gmail.com
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        $commandBus = $this->get('event_sourcing.command_bus');

        $commandBus->addCommand(
            new CreateAuthor(
                new Author(
                    null,
                    'J. R. R.',
                    'Tolkien'
                )
            )
        );

        $commandBus->addCommand(
            new CreateAuthor(
                new Author(
                    null,
                    'George R. R.',
                    'Martin'
                )
            )
        );

        $commandBus->dispatch();

        return $this->render('base.html.twig');
    }
}
