<?php

namespace App\Controller;

use App\Entity\Drivers;
use App\Form\DriversType;
use App\Repository\DriversRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api')]
class DriverController extends AbstractController
{

    #[Route('/driver', name: 'driver', methods: 'GET')]
    public function index(DriversRepository $driversRepository)
    {
        return new JsonResponse(
            ['driver' => $driversRepository->findAll(),
            ], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/driver/{id}', name: 'id_driver', methods: 'GET')]
    public function view($id, DriversRepository $driversRepository)
    {
        $drive = $driversRepository->find($id);

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

    #[Route('/new_driver', name: 'new_driver', methods: 'POST')]
    public function new(Request $request, ManagerRegistry $doctrine,)
    {
        $driver = new Drivers();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(DriversType::class, $driver);
        $form->submit($data);


        $driver->setDob(new \DateTime());
        $em = $doctrine->getManager();
        $em->persist($form->getData());
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok'
            ], JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/edit_driver/{id}/', name: 'edit_driver', methods: 'POST')]
    public function edit(Request $request, $id, ManagerRegistry $doctrine, DriversRepository $driversRepository)
    {

        $driver = $driversRepository->find($id);

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(DriversType::class, $driver);
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

    #[Route('/delete_driver/{id}/', name: 'delete_driver', methods: 'DELETE')]
    public function delete($id, ManagerRegistry $doctrine, DriversRepository $driversRepository)
    {

        $driver = $driversRepository->find($id);

        $em = $doctrine->getManager();
        $em->remove($driver);
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok'
            ], JsonResponse::HTTP_CREATED
        );
    }


}
