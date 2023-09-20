<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('/character', name: 'app_character')]
    public function index(): Response
    {
        $characters = ['Mark Evans',"Jack Wallside", "Byron Love", "Axel Blaze", "Kevin Dragonfly","Nathan Swift"];

        return $this->render('index.html.twig',array(
            'characters' => $characters
        ));
    }
}
