<?php

namespace App\Controller;

use App\Services\resizeImage;
use App\Services\resolveSession;
use App\Form\UploadImageUserType;
use App\Form\CreateEntitesType;
use App\Form\SuppUsertType;
use App\Form\EntiteChangeType;
use App\Form\SalleStorageType;
use App\Form\AddRespType;
use App\Form\AddNonGereType;
use App\Entity\Entites;
use App\Entity\RespStock;
use App\Entity\SalleStorage;
use App\Entity\Materiel;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SalleProd;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;

class EntitesController extends AbstractController
{
    /**
     * @Route("/admin/entites/list", name="entites_list")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        $entite = new Entites();
        $form = $this->createForm(CreateEntitesType::class, $entite);
        $entites = $this->getDoctrine()->getRepository(Entites::class)->findAll();
        return $this->render('entites/index.html.twig', [
            'controller_name' => 'EntitesController',
            'autocomp_user' => "entites.js",
            'entites'=> $entites,
            'registrationForm' => $form->createView(),
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

            $entites->setName($form->get('name')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entites);
            $entityManager->flush();
            $lastinsert = $entites->getId();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('entites_entite_id', ['id' => $lastinsert]));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('entites_list'));
    }

    /**
     * @Route("/resp/register/{id}", name="resp_register")
     * @IsGranted("ROLE_USER")
     */
    public function register_resp(Request $request, int $id): Response
    {
        $resp = new RespStock();
        $form = $this->createForm(AddRespType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entite = $this->getDoctrine()->getRepository(Entites::class)->find($id);
            $idresp = $form->get('id_resp')->getData();
            $uniq = md5($idresp->getId() ."-". $id);
            $resp->setIdEntites($id);
            $resp->setIdResp($idresp->getId());
            $resp->setUser($idresp);
            $resp->setEntites($entite);
            $resp->setUniq($uniq);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resp);
            $entityManager->flush();
            $lastinsert = $resp->getIdEntites();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('entites_entite_id', ['id' => $lastinsert]));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('entites_list'));
    }

    /**
     * @Route("/salle/register/{id}", name="salle_register")
     * @IsGranted("ROLE_USER")
     */
    public function register_salle(Request $request, int $id): Response
    {
        $salles = new SalleStorage();
        $form = $this->createForm(SalleStorageType::class, $salles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entite = $this->getDoctrine()->getRepository(Entites::class)->find($id);
            $salles->setSiteId($id);
            $salles->setName($form->get('name')->getData());
            $salles->setPosition($form->get('position')->getData());
            $salles->setEntites($entite);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salles);
            $entityManager->flush();
            $lastinsert = $salles->getSiteId();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('entites_entite_id', ['id' => $lastinsert]));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('entites_list'));
    }

    /**
     * @Route("/admin/entites/entite/{id}", name="entites_entite_id")
     * @IsGranted("ROLE_USER")
     */
    public function list_entite_id(Request $request, int $id): Response
    {
        $session = new resolveSession();
        $session->set('entity_id', $id);
        $entite = $this->getDoctrine()->getRepository(Entites::class)->find($id);

        $form = $this->createForm(EntiteChangeType::class, $entite);
        $form_img = $this->createForm(UploadImageUserType::class, $entite);
        $form_delete = $this->createForm(SuppUsertType::class);
        $salles = new SalleStorage();
        $form_salle = $this->createForm(SalleStorageType::class, $salles);
        $resp = new RespStock();
        $form_resp = $this->createForm(AddRespType::class, $resp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entite->setName($form->get('name')->getData());
            $entite->setAdresse($form->get('adresse')->getData());
            $entite->setVille($form->get('ville')->getData());
            $entite->setCodep($form->get('codep')->getData());
            $entite->setTelEntite($form->get('tel_entite')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('entites_entite_id', ['id' => $id]));
        }

        $respstock = $this->getDoctrine()->getRepository(RespStock::class)->findBy(array('id_entites' => $id));
        $listsalle = $this->getDoctrine()->getRepository(SalleStorage::class)->findBy(array('site_id' => $id));
        //dump($respstock);
        //exit();

        return $this->render('entites/entite.edit.html.twig', [
            'formobject' => $form->createView(),
            'form_img' => $form_img->createView(),
            'form_supp' => $form_delete->createView(),
            'entite' => $entite,
            'form_salle' => $form_salle->createView(),
            'respstock' => $respstock,
            'form_resp'=> $form_resp->createView(),
            'listsalle'=> $listsalle
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
