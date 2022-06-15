<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Contacto;

class MensajesContactoController extends AbstractController
{
    #[Route('/mensajes-contacto', name: 'mensajes_contacto')]
    public function obtenerTodosLosMensajes(Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        
        $em = $doctrine->getManager();
        $mensajes = $em->getRepository(Contacto::class)->findAll();
        
        return $this->render('mensajes_contacto/index.html.twig', [
            'controller_name' => 'MensajesContactoController',
            'mensajes' => $mensajes
        ]);
    }
    
    /**
     * @Route("ver-mensaje/{id<\d+>}", name="verMensaje")
     */
    public function verMensajeUsuario(Request $request, ManagerRegistry $doctrine, Contacto $contacto): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        
        return $this->render('mensajes_contacto/ver_mensaje.html.twig', [
            'controller_name' => 'MensajesContactoController',
            'mensaje' => $contacto
        ]);
    }
}
