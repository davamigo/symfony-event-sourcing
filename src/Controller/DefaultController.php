<?php

namespace App\Controller;

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
        $connection = $this->get('amqp.connection');

        $channel = $connection->channel();

        $channel->exchange_declare(
            'app.events.x',
            'fanout',
            false,
            true,
            false
        );

        return $this->render('base.html.twig');
    }
}
