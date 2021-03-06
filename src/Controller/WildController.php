<?php

// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CommentType;
use App\Form\ProgramSearchType;
use App\Repository\CommentRepository;
use App\Repository\ProgramRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    const NB_PROGRAM_SHOWED = 3;

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @param ProgramRepository $programRepository
     * @return Response
     */
    public function index(Request $request, ProgramRepository $programRepository): Response
    {
        $programs= $programRepository->findAllWithCategories();
        if (!$programs){
            throw $this->createNotFoundException('No program found in program\'s table.');
        }
        $form = $this->createForm(ProgramSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $programs = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findByTitle($data);
            }


        return $this->render('wild/index.html.twig', ['programs'=> $programs,
            'form'=>$form->createView()]);
    }

    /**
     *
     * @param string $slug
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['slug' => $slug]);

        if (!$program){
            throw $this->createNotFoundException('No program with ' . $slug . ' title, found in program\'s table.');
        }
        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }

    /**
     * @Route("/category/{categoryName}", name="show_category")
     * @param string $categoryName
     * @return Response
     */
    public function showByCategory(string $categoryName): Response
    {
        if (!$categoryName) {
            throw $this->createNotFoundException('No category name has been sent to find a category in category\'s table.');
        }
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=>mb_strtolower($categoryName)]);

        if (!$category) {
            throw $this->createNotFoundException('No category has been found in this category in category\'s table.');
        }
        $programs = $this->getDoctrine()->getRepository(Program::class)->findBy(
            ['category'=>$category->getId()],
            ['id' => 'DESC'],
            self::NB_PROGRAM_SHOWED);
        if (!$programs) {
            throw $this->createNotFoundException('No series has been found in this category in program\'s table.');
        }
        return $this->render('wild/category.html.twig', [
            'Category' => $category,
            'programs' => $programs,
            ]);

    }

    /**
     * @Route("/program/{slug<^[a-z0-9-]+$>}", name="show_program")
     * @param string $slug
     * @return Response
     */
    public function showByProgram(string $slug): Response
    {
        $slug = str_replace('-', ' ', $slug);
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title'=>$slug]);
        $seasons = $program->getSeasons();

        return $this->render('wild/program.html.twig', [
            'slug'  => $slug,
            'program' => $program,
        ]);
    }

    /**
    * @Route("/season/{id}", name = "show_season")
    **/
    public function showBySeason(int $id)
    {
        $season= $this->getDoctrine()->getRepository(Season::class)->findOneBy(['id'=>$id]);
        $program = $season->getProgram();
        $episodes = $season->getEpisodes();

        return $this->render('wild/season.html.twig', ['program' => $program,
        'episodes'=> $episodes,
        'season'=> $season]);
    }

    /**
     * @Route("/{id}", name="show_episode")
     * @param Episode $episode
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function showEpisode(Episode $episode, Request $request, EntityManagerInterface $entityManager,
                                UserRepository $userRepository, CommentRepository $commentRepository): Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();
        $comment = new Comment();
        $comments = $commentRepository->findBy(['episode' => $episode]);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $comment->setAuthor($userRepository->findOneBy(['email' => $this->getUser()->getUsername()]));
            $comment->setEpisode($episode);
            $entityManager->persist($comment);

            $entityManager->flush();

            return $this->redirectToRoute('wild_show_episode', ['id'=>$episode->getId()]);
        }

        return $this->render('wild/episode.html.twig', [
            'episode'=>$episode,
            'season'=> $season,
            'program'=> $program,
            'comments'=> $comments,
            'form'=> $form->createView(),
        ]);

    }

}

