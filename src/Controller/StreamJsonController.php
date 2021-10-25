<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreamJsonController extends AbstractController
{
    /**
     * @Route("/stream/json/{file}", methods={"POST"}, name="stream_json")
     * @Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_USER')")
     */
    public function index(): Response
    {
        return $this->render('stream_json/index.html.twig', [
            'controller_name' => 'StreamJsonController',
        ]);
    }
}
