<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\RespuestaJson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validation;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/user-register', name: 'user-register', methods: 'POST')]
    public function register(Request $request, RespuestaJson $resjson, ManagerRegistry $doctrine)
    {

        $json = $request->get('json', null);
        $params = json_decode($json);

        $data = [
            'status' => 'error',
            'code' => 200,
            'message' => 'El usuario no se ha creado',
            'json' => $json

        ];

        if ($json != null) {
            $username = (!empty($params->username)) ? $params->username : null;
            $email = (!empty($params->email)) ? $params->email : null;
            $password = (!empty($params->password)) ? $params->password : null;

            $validator = Validation::createValidator();
            $validateEmail = $validator->validate($email, [
                new  Email()
            ]);

            if (!empty($username) && !empty($email) && count($validateEmail) == 0 && !empty($password)) {
                $user = new User();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setRoles(['ROLE_USER']);

                $pwd = hash('sha256', $password);
                $user->setPassword($pwd);

                $em = $doctrine->getManager();

                $userRepo = $doctrine->getRepository(User::class);
                $issetUser = $userRepo->findBy(array(
                    'email' => $email
                ));

                if (count($issetUser) == 0) {

                    $em->persist($user);
                    $em->flush();

                    $data = [
                        'status' => 'succes',
                        'code' => 200,
                        'message' => 'El usuario no se ha creado',
                        'json' => $user

                    ];

                } else {
                    $data = [
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El usuario ya existe',
                        'json' => $json

                    ];
                }

            }
        }
        return $resjson->resjson($data);
    }
}
