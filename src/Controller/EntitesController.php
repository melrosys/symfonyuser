<?php

namespace App\Controller;

use App\Services\resizeImage;
use App\Form\UploadImageUserType;
use App\Form\CreateEntitesType;
use App\Form\SuppUsertType;
use App\Form\EntiteChangeType;
use App\Entity\Entites;
use App\Entity\RespStock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class EntitesController extends AbstractController
{
    /**
     * @Route("/admin/entites/list", name="entites_list")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        $entites = $this->getDoctrine()->getRepository(Entites::class)->findAll();
        return $this->render('entites/index.html.twig', [
            'controller_name' => 'EntitesController',
            'autocomp_user' => "entites.js",
            'entites'=> $entites
        ]);
    }

    /**
     * @Route("/entites/register", name="entites_register")
     * @IsGranted("ROLE_USER")
     */
    public function register(Request $request): Response
    {
        $entites = new Entites();
        $form = $this->createForm(CreateEntitesType::class, $entites);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $entites->setName($form->get('name')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entites);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('entites_register'));
        }
        return $this->render('entites/register.html.twig', [
            'controller_name' => 'EntitesController',
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/entites/entite/{id}", name="entites_entite_id")
     * @IsGranted("ROLE_USER")
     */
    public function list_entite_id(Request $request, int $id): Response
    {
        $entite = $this->getDoctrine()->getRepository(Entites::class)->find($id);
        $form = $this->createForm(EntiteChangeType::class, $entite);
        $form_img = $this->createForm(UploadImageUserType::class, $entite);
        $form_delete = $this->createForm(SuppUsertType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entite->setName($form->get('name')->getData());
            $entite->setAdresse($form->get('adresse')->getData());
            $entite->setVille($form->get('ville')->getData());
            $entite->setCodep($form->get('codep')->getData());
            $entite->setTelEntite($form->get('tel_entite')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('entites_entite_id', ['id' => $id]));
        }

        $respstock = $this->getDoctrine()->getRepository(RespStock::class)->findAllOrdered($id);
        //var_dump($respstock);exit();
        return $this->render('entites/entite.change.html.twig', [
            'formobject' => $form->createView(),
            'form_img' => $form_img->createView(),
            'form_supp' => $form_delete->createView(),
            'entite' => $entite,
            'respstock' => $respstock
        ]);
    }

    /**
     * @Route("/admin/entite/uploadimg/{id}", name="upload_entite_image")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     * @var UploadedFile $imageFile
     */
    public function upload_users_image(Request $request, $id): Response
    {
        $form_img = $this->createForm(UploadImageUserType::class);
        $form_img->handleRequest($request);

        if ($form_img->isSubmitted()/* && $form_img->isValid()*/) {
            $entite = $this->getDoctrine()->getRepository(Entites::class)->find($id);
            $imageFile = $form_img->get('picture')->getData();
            $resizeImg = new resizeImage();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $id . '-' . md5($id) . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('entite_logo_directory'),
                        $newFilename
                    );
                    //$resizeImg->resize($this->getParameter('entite_logo_directory') . "/" . $newFilename);
                    $em = $this->getDoctrine()->getManager();
                    $entite->setPicture($newFilename);
                    $em->flush();
                    $this->addFlash('success', 'Image Uploader');
                    return
                    $this->redirect($this->generateUrl('entites_entite_id', ['id' => $id]));
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload

                }
            }
        }

        $this->addFlash('error', 'Une erreur est survenue. Upload Image.');
        return $this->redirect($this->generateUrl('entites_entite_id', ['id' => $id]));
    }

    /**
     * @Route("/admin/entite/delete/{id}", name="admin_entite_supp")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_entite_supp(Request $request, int $id): Response
    {
        $form = $this->createForm(SuppUsertType::class);
        $form->handleRequest($request);
        $confirm = $form->get('confirme')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            if (strtoupper($confirm) == "SUPP") {
                $users = $this->getDoctrine()->getRepository(Entites::class)->find($id);
                $em = $this->getDoctrine()->getManager();
                $em->remove($users);
                $em->flush();
                $this->addFlash('success', 'Modification effectué.');
                return $this->redirect($this->generateUrl('admin_user_list'));
            } else {
                $this->addFlash('error', 'Saisir le mot de confirmation. ' . $confirm);
                return $this->redirectToRoute('admin_user_list');
            }
        }

        $this->addFlash('error', 'Une erreur est srvenue.' . $confirm);
        return $this->redirectToRoute('admin_user_list');
    }
}
