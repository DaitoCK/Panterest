<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $pinRepository): Response
    {
        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pins/index.html.twig', compact('pins'));
    }

    /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show")
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }

}






/*
     * @Route("/add", name="app_add")

    public function add(EntityManagerInterface $em): Response
    {
        $pin = new Pin;
        $pin->setTitle('title3');
        $pin->setDescription('DEsc3');
        $pin->setCreatedAt(new \DateTime);
        $pin->setUpdatedAt(new \DateTime);
        $em->persist($pin);
        $em->flush();
        dd($pin);
        return $this->render('pins/add.html.twig', compact('pin'));
    }
     */
