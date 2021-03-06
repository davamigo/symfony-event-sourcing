<?php

namespace App\Controller;

use App\BusinessLogic\Domain\Command\CreateAuthor;
use App\BusinessLogic\Domain\Command\UpdateAuthor;
use App\BusinessLogic\Domain\Entity\Author;
use Davamigo\Domain\Core\Uuid\UuidObj;
use MongoDB\Model\BSONDocument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * Homepage controller - shows the main menu
     *
     * @return Response
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
//        $commandBus = $this->get('event_sourcing.command_bus');
//
//        $tolkien = new Author(
//            null,
//            'J. R. R.',
//            'Tolkien'
//        );
//
//        $commandBus->addCommand(new CreateAuthor(clone $tolkien));
//
//
//        $martin = new Author(
//            null,
//            'George R. R.',
//            'Martin',
//            new \DateTime('1948-09-20')
//        );
//
//        $commandBus->addCommand(new CreateAuthor(clone $martin));
//
//        $tolkien->setBornDate(new \DateTime('1892-01-03'));
//        $tolkien->setDiedDate(new \DateTime('1973-09-02'));
//
//        $commandBus->addCommand(new UpdateAuthor(clone $tolkien));


//        $projector = $this->get('event_sourcing.entity_projector');
//
//        $result = $projector->findEntity(UuidObj::fromString('818641da-f615-11e7-aaef-13aa4ce55a47'));
//
//        dump($result);

//        $em = $this->getDoctrine()->getManager();
//
//        $list = $em->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
//
//        dump($list);
//        dump(get_class_methods($list[0]));

        return $this->render('Default/homepage.html.twig');
    }
}
