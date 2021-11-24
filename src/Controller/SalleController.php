<?php

namespace App\Controller;

use App\Entity\Entites;
use App\Entity\RespStock;
use App\Entity\SalleStorage;
use App\Entity\Materiel;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SalleProd;
use App\Services\resizeImage;
use App\Services\resolveSession;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class SalleController extends AbstractController
{
    /**
     * @Route("/admin/entites/salle/{id}", name="entites_salle_id")
     * @IsGranted("ROLE_USER")
     */
    public function list_salle_id(Request $request, int $id): Response
    {
        $session = new resolveSession();
        $salle = $this->getDoctrine()->getRepository(SalleStorage::class)->find($id);
        $session->set('salle_id', $id);
        $site_id = $salle->getSiteId();
        $session->set('entity_id', $site_id);
        $materiel = $this->getDoctrine()->getRepository(Materiel::class)->findAll();
        $product = $this->getDoctrine()->getRepository(Product::class)->findLinkMateriel($id);

        return $this->render('salle/salle.html.twig', [
            'identity' => $site_id,
            'salle' => $salle,
            'products' => $product,
            'materiels' => $materiel
        ]);
    }


    /**
     * @Route("/admin/entites/salle/materiel/{id}", name="entites_salle_materiel_id")
     * @IsGranted("ROLE_USER")
     */
    public function list_salle_materiel_id(Request $request, int $id): Response
    {
        $session = new resolveSession();
        if ($session->exist_elem(array("salle_id")) == null) {
            return $this->redirect($this->generateUrl('entites_list'));
        }

        $salle_id = $session->get("salle_id");

        $salle = $this->getDoctrine()->getRepository(SalleStorage::class)->find($salle_id);
        $materiel_cat = $this->getDoctrine()->getRepository(Category::class)->findBy(array("parent" => $id));
        $materiel = $this->getDoctrine()->getRepository(Materiel::class)->find($id);
        $session->set("materiel_id", $id);

        $product = $this->getDoctrine()->getRepository(Product::class)->findMateriel($id, $salle_id);
        return $this->render('salle/salle.materiel.html.twig', [
            'identity' => $salle_id,
            'salle' => $salle,
            'categories' => $materiel_cat,
            'products' => $product,
            'materiel' => $materiel
        ]);
    }


    /**
     * @Route("/admin/entites/salle/category/{id}", name="entites_salle_category__id")
     * @IsGranted("ROLE_USER")
     */
    public function list_salle_category_id(Request $request, int $id): Response
    {
        $session = new resolveSession();
        if ($session->exist_elem(array("salle_id", "materiel_id")) == null) {
            return $this->redirect($this->generateUrl('entites_list'));
        }

        $salle_id = $session->get("salle_id");
        $salle = $this->getDoctrine()->getRepository(SalleStorage::class)->find($salle_id);

        $materiel_id = $session->get("materiel_id");
        $materiel_cat = $this->getDoctrine()->getRepository(Category::class)->findBy(array("parent" => $materiel_id));
        $materiel = $this->getDoctrine()->getRepository(Materiel::class)->find($materiel_id);

        $product = $this->getDoctrine()->getRepository(Product::class)->findLinkCategory($id, $salle_id);
        $categorie = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $session->set('category_id', $id);

        return $this->render('salle/salle.category.html.twig', [
            'identity' => $materiel_id,
            'salle' => $salle,
            'categories' => $materiel_cat,
            'products' => $product,
            'materiel' => $materiel,
            'categorie' => $categorie
        ]);
    }

    /**
     * @Route("/admin/entites/salle/addgerer/{id}", name="entites_salle_addgerer")
     * @IsGranted("ROLE_USER")
     */
    public function entites_salle_addgerer(Request $request, int $id): Response
    {
        $session = new resolveSession();
        if ($session->exist_elem(array("salle_id")) == null) {
            return $this->redirect($this->generateUrl('entites_list'));
        }

        $form = $this->createForm(AddNonGereType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salles = new SalleProd();
            $salle_relation = $this->getDoctrine()->getRepository(SalleStorage::class)->find($form->get('sallestorage_id')->getData());
            $product_relation = $this->getDoctrine()->getRepository(Product::class)->find($form->get('product_id')->getData());
            $salles->setQuantity(0);
            $salles->setProduct($product_relation);
            $salles->setSalleStorage($salle_relation);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salles);
            $entityManager->flush();

            $referer = $request->headers->get('referer');
            $this->addFlash('success', 'Nouveau produit géré.');
            return $this->redirect($referer);
        }

        $salle_id = $session->get("salle_id");
        $salle = $this->getDoctrine()->getRepository(SalleStorage::class)->find($salle_id);
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);


        return $this->render('salle/add.gerer.html.twig', [
            'salle' => $salle,
            'product' => $product,
            'formobject' => $form->createView()
        ]);
    }
}
