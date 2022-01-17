<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use JetBrains\PhpStorm\Pure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/room', name: 'room.')]
class RoomController extends AbstractController
{
    #[Route('/', name: 'edit')]
    public function index(RoomRepository $roomRepo): Response
    {
        $rooms = $roomRepo->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $room = new Room();
        $room->setName('one');
        $room->setOnlyForPremiumMembers('false');

        //entitymanager
        $em = $doctrine->getManager();
        //store
        $em->persist($room);
        //send
        $em->flush();


        //reponse
        return new Response("Room has been created");
    }
}
