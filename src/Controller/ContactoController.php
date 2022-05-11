<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Contacto;

class ContactoController extends AbstractController
{
    /**
     * @Route("/contacto", name="contacto")
     */
    public function insertar(Request $request, ManagerRegistry $doctrine): Response {
        $contacto = new Contacto();
        $form = $this->createFormBuilder($contacto)
                ->add("descripcion", TextareaType::class, [
                    'label' => false,
                ])
                ->add('enviar', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contacto = $form->getData();
            $contacto->setUsuario($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($contacto);
            $em->flush();
            $this->addFlash("aviso", "Información enviada");
            return $this->redirectToRoute("contacto");
        }
        return $this->renderForm('contacto/index.html.twig', ['form_contacto' => $form]);
    }
}
