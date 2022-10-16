<?php

namespace App\Controller;

use App\Form\RouteType;
use App\Repository\RouteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class RouteController extends AbstractController
{
    #[Route('/route', name: 'app_route')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RouteController.php',
        ]);
    }

    #[Route('/new_route', name: 'new_route', methods: 'POST')]
    public function new(Request $request, ManagerRegistry $doctrine,)
    {

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(RouteType::class, new \App\Entity\Route());
        $form->submit($data);

        $em = $doctrine->getManager();
        $em->persist($form->getData());
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok'
            ], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/route/{id}', name: 'id_route', methods: 'GET')]
    public function view($id, RouteRepository $routeRepository)
    {
        $drive = $routeRepository->find($id);

        if (!isset($drive)) {
            return new JsonResponse(
                ['status' => 'error',
                ], JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            ['driver' => $drive,
            ], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/edit_route/{id}/', name: 'edit_route', methods: 'POST')]
    public function edit(Request $request, $id, ManagerRegistry $doctrine, RouteRepository $routeRepository)
    {

        $route = $routeRepository->find($id);

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(\App\Entity\Route::class, $route);
        $form->submit($data);

        $em = $doctrine->getManager();
        $em->persist($form->getData());
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok'
            ], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/delete_route/{id}/', name: 'delete_route', methods: 'DELETE')]
    public function delete($id, ManagerRegistry $doctrine, RouteRepository $routeRepository)
    {

        $route = $routeRepository->find($id);

        $em = $doctrine->getManager();
        $em->remove($route);
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok'
            ], JsonResponse::HTTP_CREATED
        );
    }
}
