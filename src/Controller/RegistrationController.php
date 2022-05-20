<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegistrationController extends AbstractController {

    #[Route('/registro', name: 'registro')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response {
        $user = new Usuario();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $errors = "";

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('imagen')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImagen($newFilename);
            }
            // encode the plain password
            $edad = $form->get("fecha_nacimiento")->getData();
            $user->setEdad($edad);
            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                    )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('index');
        }
        ;
        return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/registro/usuarios", name="registroUsuarios")
     */
    public function obtenerNombreUsuario(Request $request, ManagerRegistry $doctrine): Response {
        if ($request->isXmlHttpRequest()) {
            $data = $request->get("usuario");
            $em = $doctrine->getManager();
            $usuario = $em->getRepository(Usuario::class)->findUsuario($data);
            if (!empty($usuario)) {
                $respuesta = array("resultado" => true);
            } else {
                $respuesta = array("resultado" => false);
            }
            
            return new JsonResponse($respuesta);
        } else {
            throw new Exception(message: 'Error en la respuesta');
        }
    }
    
    /**
     * @Route("/registro/email", name="registroUsuariosEmail")
     */
    public function obtenerEmail(Request $request, ManagerRegistry $doctrine): Response {
        if ($request->isXmlHttpRequest()) {
            $data = $request->get("email");
            $em = $doctrine->getManager();
            $email = $em->getRepository(Usuario::class)->findEmail($data);
            if (!empty($email)) {
                $respuesta = array("resultado" => true);
            } else {
                $respuesta = array("resultado" => false);
            }
            
            return new JsonResponse($respuesta);
        } else {
            throw new Exception(message: 'Error en la respuesta');
        }
    }

}
