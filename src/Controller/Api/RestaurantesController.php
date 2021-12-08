<?php

namespace App\Controller\Api;


use App\Entity\Restaurante;

use App\Form\Type\RestauranteFormType;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



/**
 * @Rest\Route("/restaurante")
 */
class RestaurantesController extends AbstractFOSRestController
{
        private $restauranteRepository;
        private $em;


        public function __construct(RestauranteRepository $restauranteRepository, EntityManagerInterface $em)
        {
                $this->em= $em;
                $this->restauranteRepository = $restauranteRepository;
        }

// devolver listado de restaurante

    /**
     * @Rest\Get (path="/list")
     * @Rest\View (serializerGroups={"restaurante_list"}, serializerEnableMaxDepthChecks=true)
     */
    // serializerEnableMaxDepthChecks=true -> evita que se comentan bucles

    public function restauranteList(){
        $restaurantes = $this->restauranteRepository->findAll();
// principio de negacion primero, comprobando primero si se encuentra algo en la variable
        if(!$restaurantes){
            return new Response('Not found', Response::HTTP_NOT_FOUND);
        }

        return $restaurantes;

    }

    // devolver un restaurante por id
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"restaurante_id"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function getRestaurante(Request $request){

        $id = $request->get('id');
        $restaurante = $this->restauranteRepository->find($id);

        // comprobamos que id no sea null
        if(!$id){
            return new Response('not id send', Response::HTTP_BAD_REQUEST);
        }
        $restaurante = $this->restauranteRepository->find( $id );

        if(!$restaurante){
            return new Response('Not found', Response::HTTP_NOT_FOUND);

        }

        return $restaurante;

    }

    /**
     * @Rest\Post (path="")
     * @Rest\View  (serializerGroups={"restaurante"} ,serializerEnableMaxDepthChecks=true)
     *
     */

    public function restauranteCreate(request $request){

        $restaurante= new Restaurante();
        $restaurante->setValoracionMedia(intval(0));

        //Crear un form, este recibe dos argumentos:
        // el tipo formulario, y el objeto al que va asociado
        $form = $this->createForm(RestauranteFormType::class, $restaurante);
        // le decimos al formulario que maneje la request
        $form->handleRequest($request);

//        Principio de negacion
        //comprobar que se ha submiteado y si esvalido
        if(!$form->isSubmitted() || !$form-> isValid()){
            //devolver un mensajes de erro
            return $form;
        }


        $this->em->persist($restaurante);
        $this->em->flush();

        return $restaurante;
    }

    /**
     * @Rest\Get (path="/horarios/{id}")
     * @Rest\View (serializerGroups={"restaurante_horarios"}, serializerEnableMaxDepthChecks=true)
     */

    public function getHorariosRestaurante(Request $request){

        $id = $request->get('id');
        if(!$id){
            return new Response('No id send', Response::HTTP_BAD_REQUEST);
        }
        $restauranteHorarios = $this->restauranteRepository->find($id);
        if(!$restauranteHorarios){
            return new Response('Not found', Response::HTTP_NOT_FOUND);
        }
        return $restauranteHorarios;

    }

}