<?php

namespace App\Controller\Api;

use App\Form\Type\PlatoFormType;
use App\Repository\PlatoRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route ("/plato")
 */

class PlatoController extends AbstractApiController
{
    private $platoRepository;
    private $em;

    public function __construct(PlatoRepository $platoRepository, EntityManagerInterface $em){
        $this->em = $em;
        $this-> platoRepository = $platoRepository;
    }

    /**
     * @Rest\Post (path="")
     * @Rest\View (serializerGroups={"plato"}, serializerEnableMaxDepthChecks=true)
     */
    public function createPlato(Request $request){
        $form = $this->buildForm(PlatoFormType::class);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            return new Response('Bad data', Response::HTTP_BAD_REQUEST);
        }
        $plato = $form->getData();
        $this->em->persist($plato);
        $this->em->flush();
        return $plato;
    }
}