<?php

namespace App\Controller;

use App\Form\CharacterFormType;
use App\Repository\CharacterRepository;
use App\Repository\TeamRepository;
use App\Entity\Characters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 

class CharacterController extends AbstractController
{

    private $em;
    private $characterRepository;
    public function __construct(CharacterRepository $characterRepository, EntityManagerInterface $em) 
    {
        // $this->raceRepository = $raceRepository;
        $this->characterRepository = $characterRepository;
        $this->em = $em;
    }

    #[Route('/', methods: ['GET'], name: 'characters')]
    public function index(): Response
    {
        $characters = $this->characterRepository->findAll();

        return $this->render('characters/index.html.twig', [
            'characters' => $characters
        ]);
    }

    #[Route('/characters/{id}', methods: ['GET'], name: 'character')]
    public function show($id): Response
    {
        $character = $this->characterRepository->find($id);

        return $this->render('characters/show.html.twig', [
            'character' => $character
        ]); 
    }
}
