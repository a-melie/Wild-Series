<?php


namespace App\Controller;

use App\Repository\ProgramRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    const NB_PROGRAM_SHOWED = 3;

    /**
     * @Route("/", name="app_index")
     * @param ProgramRepository $programRepository
     * @return Response
     */
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findBy([],['id'=> 'DESC'],self::NB_PROGRAM_SHOWED);
        return $this->render('home.html.twig', [
            'bienvenue' => 'Bienvenue sur Wild Séries !',
            'programs' => $programs,
        ]);
    }

}
