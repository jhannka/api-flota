<?php

namespace App\Controller;

use App\Entity\Drivers;
use App\Service\RespuestaJson;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DriverController extends AbstractController
{


    #[Route('/driver', name: 'app_driver')]
    public function index(ManagerRegistry $doctrine, RespuestaJson $resjson)
    {

        $drivers = $doctrine->getRepository(Drivers::class)->findAll();

        return $resjson->resjson($drivers);
    }
}
