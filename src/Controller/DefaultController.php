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
//        $connection = $this->get('amqp.connection');
//
//        $channel = $connection->channel();
//
//        $channel->exchange_declare(
//            'app.events.x',
//            'fanout',
//            false,
//            true,
//            false
//        );

        $author = new Author(null, 'J.R.R.', 'Tolkien');

        $createAuthorCommand = new CreateAuthor($author);

        $commandBus = $this->get('event_sourcing.command_bus');
        $commandBus->addCommand($createAuthorCommand);
        $commandBus->dispatch();

        return $this->render('base.html.twig');
    }
}
