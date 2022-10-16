<?php

namespace App\Controller;

use App\Entity\Vehicles;
use App\Form\VehiclesType;
use App\Repository\VehiclesRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class VehiclesController extends AbstractController
{
    #[Route('/vehicles', name: 'app_vehicles')]
    public function index(VehiclesRepository $vehiclesRepository): JsonResponse
    {
        return new JsonResponse(
            ['driver' => $vehiclesRepository->findAll(),
            ], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/new_vehicles', name: 'new_vehicles', methods: 'POST')]
    public function new(Request $request, ManagerRegistry $doctrine,)
    {

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(VehiclesType::class, new Vehicles());
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

    #[Route('/vehicles/{id}', name: 'id_vehicles', methods: 'GET')]
    public function view($id, VehiclesRepository $vehiclesRepository)
    {
        $vehicle = $vehiclesRepository->find($id);

        if (isset($vehicle)) {
            return new JsonResponse(
                ['vehicle' => $vehicle,
                ], JsonResponse::HTTP_CREATED
            );
        } else {
            return new JsonResponse(
                ['status' => 'error',
                ], JsonResponse::HTTP_BAD_REQUEST
            );
        }


    }

    #[Route('/edit_vehicle/{id}/', name: 'edit_vehicle', methods: 'POST')]
    public function edit(Request $request, $id, ManagerRegistry $doctrine, VehiclesRepository $vehiclesRepository)
    {

        $vehicle = $vehiclesRepository->find($id);

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(VehiclesType::class, $vehicle);
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

    #[Route('/delete_vehicle/{id}/', name: 'delete_vehicle', methods: 'DELETE')]
    public function delete($id, ManagerRegistry $doctrine, VehiclesRepository $vehiclesRepository)
    {

        $vehicle = $vehiclesRepository->find($id);

        $em = $doctrine->getManager();
        $em->remove($vehicle);
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok'
            ], JsonResponse::HTTP_CREATED
        );
    }
}
