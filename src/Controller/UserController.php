<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\RespuestaJson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/api')]
class UserController extends AbstractController
{

    #[Route('/user-register', name: 'user-register', methods: 'POST')]
    public function register(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);


        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $form->get('password')->getData()
        );

        $user->setPassword($hashedPassword);

        $user->setRoles(['ROLE_USER']);
        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok'
            ], JsonResponse::HTTP_CREATED
        );
    }
}
