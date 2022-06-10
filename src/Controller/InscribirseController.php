<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Fiestas;
use App\Entity\Inscripciones;

class InscribirseController extends AbstractController
{
    /**
     * @Route("/inscribirse", name="inscribirse")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if ($request->isXmlHttpRequest()) {
            $em = $doctrine->getManager();
            $id_usuario = $this->getUser()->getId();
            $id_fiesta = $request->get("id");
            $query = "SELECT * FROM `inscripciones` where usuario_id = $id_usuario and fiestas_id = $id_fiesta";

            $statement = $em->getConnection()->prepare($query);
            $result = $statement->executeStatement();

            if($result == 0){
                $inscripciones = new Inscripciones();
                $festival = $request->get("id");
                $usuario = $this->getUser();
                $fiestas = $em->getRepository(Fiestas::class)->find($festival);
                $inscripciones->setUsuario($usuario);
                $inscripciones->setFiestas($fiestas);
                $em->persist($inscripciones);
                $em->flush();
                $inscripcion = $em->getRepository(Inscripciones::class)->find($inscripciones->getId());
                if (!empty($inscripcion)) {
                    $respuesta = array("resultado" => true);
                } else {
                    $respuesta = array("resultado" => false);
                }
                return $this->json($respuesta);
            }
        } else {
            return $this->redirectToRoute("index");
        }
    }
}
