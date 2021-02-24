<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(PinRepository $pinRepository): Response
    {
        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pins/index.html.twig', compact('pins'));
    }
    /**
     * @Route("/pins/create", name="app_pins_create", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin;

        $form = $this->createForm(PinType::class, $pin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $pin->setCreatedAt(new \DateTime);
            $pin->setUpdatedAt(new \DateTime);
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show", methods="GET")
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }

    /**
     * @Route("/pins/{id<[0-9]+>}/edit", name="app_pins_edit")
     */
    public function edit(Pin $pin, Request $request, EntityManagerInterface $em):Response
    {
        $form = $this->createForm(PinType::class,$pin,);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig', [
            'form' => $form->createView(),
            'pin'=> $pin
        ]);

    }

    /**
     * @Route("/pins/{id<[0-9]+>}/delete", name="app_pins_delete")
     */
    public function delete(Pin $pin, EntityManagerInterface $em): Response
    {
        $em->remove($pin);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }

}

/*
     * @Route("/add", name="app_add")
     *


    public function add(EntityManagerInterface $em): Response
    {
        $pin = new Pin;
        $pin->setTitle('title4');
        $pin->setDescription('DEsc4');
        $pin->setCreatedAt(new \DateTime);
        $pin->setUpdatedAt(new \DateTime);
        $em->persist($pin);
        $em->flush();
        dd($pin);
        return $this->render('pins/add.html.twig', compact('pin'));
    }
     */







