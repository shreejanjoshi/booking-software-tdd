<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
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

        //form
        $form = $this->createForm(RoomType::class, $room);
        //store transmit data
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            //entitymanager
            $em = $doctrine->getManager();
            //array object
            $image = $request->files->get('room')['attachment'];

            if ($image){
                $dataImageName = md5(uniqid('', true)). '.'. $image->guessClientExtension();
            }
            $image->move(
                $this->getParameter('images_folder'),
                $dataImageName
            );

            $room->setImage($dataImageName);
            //store
            $em->persist($room);
            //send
            $em->flush();

            return $this->redirect($this->generateUrl('room.edit'));
        }


        //reponse
        return $this->render('room/add.html.twig', [
            //create a view from the form
            'addForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, ManagerRegistry $doctrine, RoomRepository $roomRepo): Response
    {
        $em = $doctrine->getManager();
        $room = $roomRepo->find($id);
        $em->remove($room);
        $em->flush();

        //message
        $this->addFlash('success', 'Room is deleted successfully');

        return $this->redirect($this->generateUrl('room.edit'));
    }

    #[Route('/show/{id}', name: 'show')]
    //now this is parmconvoter $request will be objects{room} and can find -$id -$name
    public function show(Room $room): Response
    {

        return $this->render('room/show.html.twig', [
            'room' => $room
        ]);
    }
}
