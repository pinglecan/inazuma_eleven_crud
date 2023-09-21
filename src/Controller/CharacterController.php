<?php

namespace App\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{

    private $em;
    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;
    }


    #[Route('/character', name: 'characters')]
    public function index(): response
    {   

        //findall() -   SELECT * FROM movies;

        return $this->render('index.html.twig');

    }
}
