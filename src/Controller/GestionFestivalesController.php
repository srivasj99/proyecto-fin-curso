<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\FileBag;
use App\Entity\Fiestas;

class GestionFestivalesController extends AbstractController {

    /**
     * @Route("/gestion-festivales", name="gestionFestivales")
     */
    public function index(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $repositorioFestival = $doctrine->getRepository(Fiestas::class);
        $festival = $repositorioFestival->findAll();

        return $this->renderForm('gestion_festivales/index.html.twig', [
                    'controller_name' => 'GestionFestivalesController',
                    'festival' => $festival,
        ]);
    }

    /**
     * @Route("/gestion-festivales/obtener-festival")
     */
    public function obtenerFestival(Request $request, ManagerRegistry $doctrine): Response {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isXmlHttpRequest()) {
            $data = $request->get("id");
            $fiesta = $repositorioFiesta = $doctrine->getRepository(Fiestas::class)->find($data);
            if (!empty($fiesta)) {
                $respuesta = array("resultado" => true);
            } else {
                $respuesta = array("resultado" => false);
            }
            return $this->json([$respuesta, $fiesta]);
        } else {
            return $this->redirectToRoute('gestionFestivales');
        }
    }

    /**
     * @Route("/gestion-festivales/insertar")
     */
    public function insertarFestival(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isXmlHttpRequest()) {
            $fiestas = new Fiestas();
            $nombreFestival = $request->get("nombreFestival");
            $brochureFile = $request->files->get("imagen");
            $descripcion = $request->get("descripcionFestival");
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
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
                $fiestas->setNombre($nombreFestival);
                $fiestas->setImagen($newFilename);
                $fiestas->setDescripcion($descripcion);
                $em = $doctrine->getManager();
                $em->persist($fiestas);
                $em->flush();
            }
            $em = $doctrine->getManager();
            $fiesta = $em->getRepository(Fiestas::class)->find($fiestas->getId());
            if (!empty($fiesta)) {
                $respuesta = array("resultado" => true);
            } else {
                $respuesta = array("resultado" => false);
            }
            return $this->json([$respuesta, $fiesta]);
        } else {
            return $this->redirectToRoute('gestionFestivales');
        }
    }

    /**
     * @Route("/gestion-festivales/editar")
     */
    public function editarFestival(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $em = $doctrine->getManager();
        if ($request->isXmlHttpRequest()) {
            $nombreFestival = $request->get("nombreFestivalEdit");
            $brochureFile = $request->files->get("imagenEdit");
            $descripcion = $request->get("descripcionFestivalEdit");
            $id = $request->get("id");
            $fiestas = $em->getRepository(Fiestas::class)->find($id);
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
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
                $fiestas->setNombre($nombreFestival);
                $fiestas->setImagen($newFilename);
                $fiestas->setDescripcion($descripcion);
            }
            $fiestas->setNombre($nombreFestival);
            $fiestas->setDescripcion($descripcion);
            $em->persist($fiestas);
            $em->flush();
            $fiesta = $em->getRepository(Fiestas::class)->find($id);
            if (!empty($fiesta)) {
                $respuesta = array("resultado" => true);
            } else {
                $respuesta = array("resultado" => false);
            }
            return $this->json([$respuesta, $fiesta]);
        } else {
            return $this->redirectToRoute('gestionFestivales');
        }
    }

    /**
     * @Route("/gestion-festivales/borrar")
     */
    public function borrarFestival(Request $request, ManagerRegistry $doctrine): Response {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        sleep(1);
        $em = $doctrine->getManager();
        if ($request->isXmlHttpRequest()) {
            $id = $request->get("id");
            $fiestas = $em->getRepository(Fiestas::class)->find($id);
            $em->remove($fiestas);
            $em->flush();
            $respuesta = true;
            return $this->json($respuesta);
        } else {
            return $this->redirectToRoute('gestionFestivales');
        }
    }

}
