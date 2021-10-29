<?php

namespace App\Controller;

use App\Services\resizeImage;
use App\Entity\User;
use App\Form\ChangePasswordUserType;
use App\Form\ChangeUserType;
use App\Form\SuppUsertType;
use App\Form\UploadImageUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Filesystem\Filesystem;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_user_list")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function list_users(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
       //$this->gen_f_ile_json_user($users);
        //exit();
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users'=> $users,
            'autocomp_user'=> "user.js"
        ]);
    }

    public function gen_f_ile_json_user($user): void
    {
        foreach($user as $key => $value)
        {
            var_dump($value);echo "<hr>";
        }
    }

    /**
     * @Route("/admin/users/{id}", name="admin_user_list_byid")
     * @IsGranted("ROLE_USER")
     */
    public function list_users_id(int $id): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(ChangeUserType::class, $users);
        $form_img = $this->createForm(UploadImageUserType::class, $users);
        $form_password = $this->createForm(ChangePasswordUserType::class, $users);
        $form_delete = $this->createForm(SuppUsertType::class);
        $role = $users->getRoles();
        return $this->render('admin/user.change.html.twig', [
            'formobject' => $form->createView(),
            'form_img' => $form_img->createView(),
            'form_password' => $form_password->createView(),
            'form_supp' => $form_delete->createView(),
            'users' => $users,
            'role' => $role[0]
        ]);
    }

    /**
     * @Route("/admin/users/password/{id}", name="admin_user_update_password")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_user_update_password(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface, int $id): Response
    {
        $form = $this->createForm(ChangePasswordUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $this->getDoctrine()->getRepository(User::class)->find($id);
            $users->setPassword(
                $userPasswordEncoderInterface->encodePassword(
                    $users,
                    $form->get('plainPassword')->getData()
                )
            );
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Modification effectué.');
            return $this->redirect($this->generateUrl('admin_user_list'));
        }
        $this->addFlash('error', 'Une erreur est srvenue.');
        return $this->redirectToRoute('admin_user_list_byid', ['id' => $id]);
    }

    /**
     * @Route("/admin/users/delete/{id}", name="admin_user_supp")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_user_supp(Request $request, int $id): Response
    {
        $form = $this->createForm(SuppUsertType::class);
        $form->handleRequest($request);
        $confirm =$form->get('confirme')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            if(strtoupper($confirm) == "SUPP")
            {
                $users = $this->getDoctrine()->getRepository(User::class)->find($id);
                $em = $this->getDoctrine()->getManager();
                $em->remove($users);
                $em->flush();

                $this->addFlash('success', 'Modification effectué.');
                return $this->redirect($this->generateUrl('admin_user_list'));
            }
            else
            {
                $this->addFlash('error', 'Saisir le mot de confirmation. '. $confirm);
                return $this->redirectToRoute('admin_user_list');
            }
        }

        $this->addFlash('error', 'Une erreur est srvenue.'. $confirm);
        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/admin/users/update/{id}", name="admin_user_update")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     */
    public function list_users_update(Request $request, $id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(ChangeUserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $form->getData();

            $role = $request->request->get('role_user');
            $roles = array($role);
            $user->setRoles($roles);

            $status = $request->request->get('status');
            $user->setStatus($status);
            $em->flush();

            
            $this->addFlash('success', 'Modification effectué');
            return $this->redirectToRoute('admin_user_list_byid', ['id' => $id]);
        }
        $this->addFlash('error', 'Une erreur est survenue');
        return $this->redirectToRoute('admin_user_list_byid', ['id' => $id]);
    }

    /**
     * @Route("/admin/users/uploadimg/{id}", name="upload_users_image")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     * @var UploadedFile $imageFile
     */
    public function upload_users_image(Request $request, $id): Response
    {
        $form_img = $this->createForm(UploadImageUserType::class);
        $form_img->handleRequest($request);

        if ($form_img->isSubmitted()/* && $form_img->isValid()*/) {
            $users = $this->getDoctrine()->getRepository(User::class)->find($id);
            $imageFile = $form_img->get('picture')->getData();
            $resizeImg = new resizeImage();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $id . '-' . md5($id) . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                    $resizeImg->resize($this->getParameter('avatar_directory') ."/" .$newFilename);
                    $em = $this->getDoctrine()->getManager();
                    $users->setPicture($newFilename);
                    $em->flush();
                    $this->addFlash('success', 'Image Uploader');
                    return $this->redirectToRoute('admin_user_list_byid', ['id' => $id]);

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload

                }
            }
        }

        $this->addFlash('error', 'Une erreur est survenue. Upload Image.');
        return $this->redirectToRoute('admin_user_list_byid', ['id' => $id]);
    }

    /**
     * @Route("/admin/tech", name="admin_tech_list")
     */
    public function list_tech(): Response
    {
        return $this->render('admin/tech.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/device", name="admin_device_list")
     */
    public function list_device(): Response
    {
        return $this->render('admin/device.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/storage", name="admin_storage_list")
     */
    public function list_storage(): Response
    {
        return $this->render('admin/device.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
