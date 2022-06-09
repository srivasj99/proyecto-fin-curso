<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fiestas;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $repositorioFestival = $doctrine->getRepository(Fiestas::class);
        $festival = $repositorioFestival->findAll();

        return $this->render('principal/index.html.twig', [
            'controller_name' => 'PrincipalController',
            'festival' => $festival,
        ]);
    }
}
