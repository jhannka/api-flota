<?php

namespace App\Controller;

use App\Entity\Schedules;
use App\Form\SchedulesType;
use App\Repository\SchedulesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SchedulesController extends AbstractController
{
    #[Route('/schedules', name: 'app_schedules')]
    public function index(SchedulesRepository $schedulesRepository): JsonResponse
    {
        return new JsonResponse(
            ['driver' => $schedulesRepository->findAll(),
            ], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/new_schedules', name: 'new_schedules', methods: 'POST')]
    public function new(Request $request, ManagerRegistry $doctrine,)
    {

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(SchedulesType::class, new Schedules());
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

    #[Route('/schedules/{id}', name: 'id_schedules', methods: 'GET')]
    public function view($id, SchedulesRepository $schedulesRepository)
    {
        $schedules = $schedulesRepository->find($id);

        if (isset($schedules)) {
            return new JsonResponse(
                ['vehicle' => $schedules,
                ], JsonResponse::HTTP_CREATED
            );
        } else {
            return new JsonResponse(
                ['status' => 'error',
                ], JsonResponse::HTTP_BAD_REQUEST
            );
        }


    }

    #[Route('/edit_schedules/{id}/', name: 'edit_schedules', methods: 'POST')]
    public function edit(Request $request, $id, ManagerRegistry $doctrine, SchedulesRepository $schedulesRepository)
    {

        $schedules = $schedulesRepository->find($id);

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(SchedulesType::class, $schedules);
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

    #[Route('/delete_schedules/{id}/', name: 'delete_schedules', methods: 'DELETE')]
    public function delete($id, ManagerRegistry $doctrine, SchedulesRepository $schedulesRepository)
    {

        $vehicle = $schedulesRepository->find($id);

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
