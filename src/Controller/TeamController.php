<?php

namespace App\Controller;

use App\Form\TeamFormType;
use App\Repository\TeamRepository;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use App\Entity\Team;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TeamController extends AbstractController
{

    private $em;
    private $teamRepository;
    public function __construct(TeamRepository $teamRepository, EntityManagerInterface $em) 
    {
        $this->teamRepository = $teamRepository;
        $this->em = $em;
    }



    #[Route('/', methods: ['GET'], name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('index.html.twig');
    }





    #[Route('/teams', methods: ['GET'], name: 'teams')]
    public function index(): Response
    {
        $teams = $this->teamRepository->findAll();

        return $this->render('./teams/index.html.twig', [
            'teams' => $teams
        ]);
    }

    #[Route("/teams/create", name:"create_team")]
    public function create(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form -> isValid()) {
            $newTeam = $form->getData();

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

                $newTeam ->setImage('/uploads/' . $newFileName);
            }
            
            $this->em->persist($newTeam);
            $this->em->flush();

            return $this ->redirectToroute('teams');

        }
    

        return $this->render('teams/create.html.twig',[
            'form' => $form->createView()
        ]);
    }


    #[Route('/teams/edit/{id}', name:'edit_team')]
    public function edit($id, Request $request): Response
    {
        $team = $this->teamRepository->find($id);
        $form = $this->createForm(TeamFormType::class, $team);
        $form->handleRequest($request);
        $image = $form-> get('image')->getData();    

        if ($form->isSubmitted() && $form->isValid()){
            if ($image) { 
                if($team->getImage() !== null){
                    if(file_exists(
                        $this->getParameter('kernel.project_dir') . '/public' . $team->getImage()
                    )){

                        $this->getParameter('kernel.project_dir') . '/public' . $team->getImage();
                        $newFileName = uniqid() . '.' . $image->guessExtension();

                        try{
                            $image->move(
                                $this->getParameter('kernel.project_dir') . '/public/uploads',
                                $newFileName
                            );
                        } catch (FileExeption $e) {
                            return new response($e ->getMessage());
                        }

                        $team->setimage('/uploads/' . $newFileName);
                        $this->em->flush();

                        return $this->redirectToRoute('teams');
                    }
                }
            }else{
                    
                    foreach($form->get('characters')->getData() as $character){
                        $team->addCharacter($character);
                    }
                    $this->em->persist($team);
                    $this->em->flush();
                    return $this->redirectToRoute('teams');
                }      

        }

        return $this->render('teams/edit.html.twig',[
            'team' => $team,
            'form' => $form->createView()
        ]);
    }


    #[Route('/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_team')]
    public function delete($id): Response
    {
        $team = $this->teamRepository->find($id);
        $this->em->remove($team);
        $this->em->flush();
        return $this->redirectToRoute('teams');
    }

    #[Route("/teams/{id}", methods: ['GET'], name: 'team')]
    public function show($id): Response
    {
    
        $team = $this->teamRepository->find($id);

        return $this->render('teams/show.html.twig', [
            'team' => $team
        ]); 
    }
}
