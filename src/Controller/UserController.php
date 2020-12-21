<?php

namespace App\Controller;

use App\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="user_login", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function login(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dataRequest = json_decode($request->getContent());

        $users = $this->getDoctrine()->getRepository(UserEntity::class)->findAll();

        foreach ($users as $user) {
            if ($user->getEmail() === $dataRequest->email && $user->getPassword() === $dataRequest->password) {
                if (!$user->getToken()) {
                    //create token
                    $token = bin2hex(random_bytes(16));

                    $user->setToken($token);
                    $entityManager->persist($user);
                    $entityManager->flush();

                } else {
                    $token = $user->getToken();
                }

                return $this->json([
                    'token' => $token
                ], 201);
            }
        }

        return $this->json([
            'message' => 'They have an error on your email or your password!'
        ], 404);
    }

    /**
     * @Route("/user/{token}", name="user_me", methods={"GET"})
     * @param Request $request
     */
    public function me(Request $request): Response
    {
        if (!$request->attributes->get('token')) {
            return $this->json([
                'message' => 'no token'
            ], 401);
        }

        $token = $request->attributes->get('token');

        $users = $this->getDoctrine()->getRepository(UserEntity::class)->findAll();

        foreach ($users as $user) {
            if ($user->getToken() === $token) {
                return $this->json([
                    'Firstname' => $user->getFirstname(),
                    'Lastname' => $user->getLastname()
                ], 200);
            }
        }

        return $this->json([
            'message' => 'Token is not valid!'
        ], 400);
    }

    /**
     * @Route("/logout/{token}", name="user_logout", methods={"DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function logout(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$request->attributes->get('token')) {
            return $this->json([
                'message' => 'no token'
            ], 401);
        }

        $token = $request->attributes->get('token');

        $users = $this->getDoctrine()->getRepository(UserEntity::class)->findAll();

        foreach ($users as $user) {
            if ($user->getToken() === $token) {
                $user->setToken(null);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->json([
                    'message' => 'You are logout!',
                ], 200);
            }
        }

        return $this->json([
            'message' => 'Token is not valid!'
        ], 400);
    }
}
