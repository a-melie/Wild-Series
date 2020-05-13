<?php

// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'wild Séries',
        ]);
    }

    /**
     * @Route("/show/{slug}",requirements={"slug" = "[a-z0-9-]+"}, name="show")
     * @param string|null $slug
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if ($slug){
            $slug = ucwords(str_replace('-', ' ', $slug));
        }else {
            $slug = 'Aucune série sélectionnée, veuillez choisir une série';
        }
            return $this->render('wild/show.html.twig', ['slug' => $slug]);
        }

}

