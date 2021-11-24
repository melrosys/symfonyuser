<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Category;
use App\Entity\Marque;
use App\Entity\Fournisseur;
use App\Entity\Product;
use App\Form\AddDeviceType;
use App\Form\AddCategoryType;
use App\Form\AddMarqueType;
use App\Form\AddFournisseurType;
use App\Form\AddProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DeviceController extends AbstractController
{
    /**
     * @Route("/admin/device", name="device")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(AddDeviceType::class, $materiel);
        $listmateriel = $this->getDoctrine()->getRepository(Materiel::class)->findAll();
        return $this->render('device/index.html.twig', [
            'controller_name' => 'Gestion du matériel',
            'autocomp_user' => "device.js",
            'materiels'=> $listmateriel,
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/device/register", name="device_register")
     * @IsGranted("ROLE_USER")
     */
    public function register(Request $request): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(AddDeviceType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $materiel = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($materiel);
            $entityManager->flush();
            $lastinsert = $materiel->getId();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('device'));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('device'));
    }

    /**
     * @Route("/admin/device/list/{id}", name="device_list")
     * @IsGranted("ROLE_USER")
     */
    public function list_device(int $id): Response
    {
        $catego = new Category();
        $form = $this->createForm(AddCategoryType::class, $catego);
        $marque = new Marque();
        $form_marque = $this->createForm(AddMarqueType::class, $marque);
        $fourni = New Fournisseur();
        $form_fournisseur = $this->createForm(AddFournisseurType::class, $fourni);
        $product = new Product();
        $form_product = $this->createForm(AddProductType::class, $product);

        $materiel = $this->getDoctrine()->getRepository(Materiel::class)->find($id);
        $listcatego = $this->getDoctrine()->getRepository(Category::class)->findBy(array('parent' => $id));
        $listproduit = $this->getDoctrine()->getRepository(Product::class)->findBy(array('id_materiel' => $id));
        //dump($listproduit);exit();
        return $this->render('device/list.html.twig', [
            'controller_name' => 'Gestion du matériel',
            'materiel' => $materiel,
            'registrationForm' => $form->createView(),
            'marqueForm' => $form_marque->createView(),
            'form_marque'=> $form_marque->createView(),
            'form_fournisseur'=> $form_fournisseur->createView(),
            'listcategos' => $listcatego,
            'form_product' => $form_product->createView(),
            'listproduit' => $listproduit
        ]);
    }

    /**
     * @Route("/admin/categorie/register/{id}", name="categorie_register")
     * @IsGranted("ROLE_USER")
     */
    public function categorie_register(Request $request, int $id): Response
    {
        $catego = new Category();
        $form = $this->createForm(AddCategoryType::class, $catego);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materiel = $this->getDoctrine()->getRepository(Materiel::class)->find($id);
            $catego = $form->getData();
            $catego->setParent($id);
            $catego->setCreateAt(new \DateTime());
            $catego->setModifiedAt(new \DateTime());
            $catego->setMateriel($materiel);
            //$materiel->setParent(-1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($catego);
            $entityManager->flush();
            $lastinsert = $catego->getId();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
    }

    /**
     * @Route("/admin/marque/register/{id}", name="marque_register")
     * @IsGranted("ROLE_USER")
     */
    public function marque_register(Request $request, int $id): Response
    {
        $marque = new Marque();
        $form = $this->createForm(AddMarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $marque = $form->getData();;
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marque);
            $entityManager->flush();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
    }

    /**
     * @Route("/admin/fournisseur/register/{id}", name="fournisseur_register")
     * @IsGranted("ROLE_USER")
     */
    public function fournisseur_register(Request $request, int $id): Response
    {
        $fourn = new Fournisseur();
        $form = $this->createForm(AddFournisseurType::class, $fourn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fourn = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fourn);
            $entityManager->flush();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
    }

    /**
     * @Route("/admin/product/register/{id}", name="product_register")
     * @IsGranted("ROLE_USER")
     */
    public function product_register(Request $request, int $id): Response
    {
        $product = new Product();
        $form = $this->createForm(AddProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product->setIdCatego($request->request->get('id_catego'));
            $product->setTitle($form->get("title")->getData());

            $marque = $form->get("marque")->getData();
            $product->setIdMarque($marque->getId());

            $fourni = $form->get("id_fourni")->getData();
            $product->setIdFourni($fourni->getId());
            $product->setIdMateriel($id);
            $product->setModel($form->get("model")->getData());
            $product->setWaranty($form->get("waranty")->getData());
            $product->setGestSn($form->get("gest_sn")->getData());
            $product->setTags($form->get("tags")->getData());
            $product->setMarque($marque);
            $product->setFournisseur($fourni);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
        }
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirect($this->generateUrl('device_list', ['id' => $id]));
    }
}
