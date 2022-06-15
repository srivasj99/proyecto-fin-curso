<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fiestas;
use App\Entity\Inscripciones;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/festival/{id<\d+>}", name="festival")
     */
    public function verFestivalSeleccionado(Request $request, ManagerRegistry $doctrine, Fiestas $festival): Response
    {
        if(!$this->getUser()){
            return $this->render('principal/festival.html.twig', [
                'controller_name' => 'PrincipalController',
                'festival' => $festival,
            ]);
        }else{
            $respuesta = "";
            $em = $doctrine->getManager();
            $usuario = $this->getUser()->getId();
            $fiesta = $festival->getId();
            $query = "SELECT * FROM `inscripciones` where usuario_id = $usuario and fiestas_id = $fiesta";

            $statement = $em->getConnection()->prepare($query);
            $result = $statement->executeStatement();

            if ($result == 0) {
                $respuesta = "no inscrito";
            } else {
                $respuesta = "inscrito";
            }

            return $this->render('principal/festival.html.twig', [
                'controller_name' => 'PrincipalController',
                'festival' => $festival,
                'respuesta' => $respuesta
            ]);
        }
    }
}
