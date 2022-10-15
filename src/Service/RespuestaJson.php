<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RespuestaJson
{

    public function resjson($data)
    {
        //Serializar datos con servivio serializer
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($data, 'json');

        //Response con HttpFoundation
        $response = new Response();

        //Asignar contenido a la respuesta
        $response->setContent($jsonContent);

        //Indicar formato a la respuesta
        $response->headers->set('content-Type', 'application/json');


        //Devolver la respuesta
        return $response;
    }
}