<?php

namespace App\Controller\Api;

use App\Form\Type\HorarioRestauranteFormType;
use App\Repository\HorarioRestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class HorariosRestauranteController extends AbstractApiController
{

    // inyección de dependencias
    private  $em;
    private $rep;

    public function  __construct(EntityManagerInterface $em, HorarioRestauranteRepository $rep)
    {
        $this->em = $em;
        $this-> rep = $rep;
    }

    // crear horarios y relacionarlo al restaurante
    /**
     * @Rest\Post (path="/horario")
     * @Rest\View (serializerGroups={"horario"}, serializerEnableMaxDepthChecks=true )
     */

    public function horarioCreate(Request $request)
    {
        // vamos a crear -> formType de horarios
        $form = $this->buildForm(HorarioRestauranteFormType::class);
//        Formulario manejame el request
        $form-> handleRequest($request);
        if(!$form->isSubmitted() || !$form-> isValid() ){
            return new Response('Datos incorrectos', Response:: HTTP_BAD_REQUEST);
        }

        $horario = $form->getData();
        $this->em->persist($horario);
        $this->em->flush();

        return $horario;

    }

}