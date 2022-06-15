<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Fiestas;
use App\Entity\Inscripciones;
use App\Entity\Usuario;

class MisInscripcionesController extends AbstractController {

    /**
     * @Route("/mis-inscripciones", name="misInscripciones")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response {
        return $this->render('mis_inscripciones/index.html.twig', [
                    'controller_name' => 'MisInscripcionesController'
        ]);
    }

    /**
     * @Route("/mis-inscripciones/obtener-inscripciones")
     */
    public function obtenerInscripciones(Request $request, ManagerRegistry $doctrine): Response {
        if ($request->isXmlHttpRequest()) {
            $em = $doctrine->getManager();
            $usuario = $this->getUser();
            $inscripcionesUsuario = $em->getRepository(Usuario::class)->find($usuario);
            $inscripcionesId = $inscripcionesUsuario->getInscripciones();
            $jsonData = array();
            foreach ($inscripcionesId as $value) {
                $inscripcion = $em->getRepository(Inscripciones::class)->find($value);
                $jsonData[] = $inscripcion;
            }
            return $this->json($jsonData);
        }else{
            return $this->redirectToRoute('misInscripciones');
        }
    }
    
    /**
     * @Route("/mis-inscripciones/borrar-inscripcion")
     */
    public function borrarInscripcion(Request $request, ManagerRegistry $doctrine): Response {
        if ($request->isXmlHttpRequest()) {
            $em = $doctrine->getManager();
            $id = $request->get('id');
            $inscripcion = $em->getRepository(Inscripciones::class)->find($id);
            $em->remove($inscripcion);
            $em->flush();
            $respuesta = true;
            return $this->json($respuesta);
        }else{
            return $this->redirectToRoute('misInscripciones');
        }
    }
}
