<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entites;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

use JMS\Serializer\SerializationContext;

class StreamJsonController extends AbstractController
{
    /**
     * @Route("/stream/json/{file}", methods={"GET"}, name="stream_json")
     * @Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_USER')")
     */
    public function index($file): response
    {
        $data = null;
        $donnee = null;
        if($file == "user.js")
        {
            $donnee = $this->getDoctrine()->getRepository(User::class)->findAllOrdered();
            $data =  $this->get('serializer')->serialize($donnee, 'json');
        }
        elseif($file == "entites.js")
        {
            $donnee = $this->getDoctrine()->getRepository(Entites::class)->findAllOrdered();
            $data =  $this->get('serializer')->serialize($donnee, 'json');
        }
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
