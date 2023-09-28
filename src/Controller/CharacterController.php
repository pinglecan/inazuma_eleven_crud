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
use App\Entity\Character;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CharacterController extends AbstractController
{

    private $em;
    private $characterRepository;
    public function __construct(CharacterRepository $characterRepository, EntityManagerInterface $em) 
    {
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

    #[Route("/characters/create", name:"create_movie")]
    public function create(Request $request): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterFormType::class, $character);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form -> isValid()) {
            $newCharacter = $form->getData();

            $image = $form->get('image')->getData();
            if($image) {
                $newFileName = uniqid() . '.' . $image->guessExtension();

                try{
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileExeption $e) {
                    return new response($e ->getMessage());
                }

                $newCharacter ->setimage('/uploads/' . $newFileName);
            }
            
            $this->em->persist($newCharacter);
            $this->em->flush();

            return $this ->redirectToroute('characters');

        }
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
        }

        return $this->render('characters/create.html.twig',[
            'form' => $form->createView()
        ]);
    }


    #[Route('/characters/edit/{id}', name:'edit_character')]
    public function edit($id, Request $request): Response
    {
        $character = $this->characterRepository->find($id);
        $form = $this->createForm(CharacterFormType::class, $character);
        $form->handleRequest($request);
        $image = $form-> get('image')->getData();    

        if ($form->isSubmitted() && $form->isValid()){
            if ($image) { 
                if($character->getImage() !== null){
                    if(file_exists(
                        $this->getParameter('kernel.project_dir') . '/public' . $character->getImage()
                    )){

                        $this->getParameter('kernel.project_dir') . '/public' . $character->getImage();
                        $newFileName = uniqid() . '.' . $image->guessExtension();

                        try{
                            $image->move(
                                $this->getParameter('kernel.project_dir') . '/public/uploads',
                                $newFileName
                            );
                        } catch (FileExeption $e) {
                            return new response($e ->getMessage());
                        }

                        $character->setimage('/uploads/' . $newFileName);
                        $this->em->flush();

                        return $this->redirectToRoute('characters');
                    }
                }
            }else{
                    
                    $character->SetTitle($form->get('title')->getData());
                    $character->setgender($form->get('gender')->getData());
                    $character->setPosision($form->get('posision')->getdata());
            
                    $this->em->flush();
                    return $this->redirectToRoute('characters');
                }      

        }

        return $this->render('characters/edit.html.twig',[
            'character' => $character,
            'form' => $form->createView()
        ]);
    }


    #[Route('/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_character')]
    public function delete($id): Response
    {
        $character = $this->characterRepository->find($id);
        $this->em->remove($character);
        $this->em->flush();
        return $this->redirectToRoute('characters');
    }

    #[Route("/characters/{id}", methods: ['GET'], name: 'character')]
    public function show($id): Response
    {
    
        $character = $this->characterRepository->find($id);

        return $this->render('characters/show.html.twig', [
            'character' => $character
        ]); 
    }
}
