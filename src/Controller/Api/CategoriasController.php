<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\Type\CategoriaFormType;
use App\Repository\CategoriaRepository;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriasController extends AbstractFOSRestController
{

    private $catRespository;
    private $em;

    public function  __construct(CategoriaRepository  $catRespository,  EntityManagerInterface $em){
        $this->catRespository = $catRespository;
        $this->em= $em;
    }

    // vamos a utilizar los anotatios del fos_rest
    /**
     * @Rest\Get(path="/categorias")
     * @Rest\View(serializerGroups={"categoria"},serializerEnableMaxDepthChecks= true)
     */
    public function getCategorias(){

        return $this->catRespository->findAll();
    }

    /**
     * @Rest\Post(path="/categoria")
     * @Rest\View (serializerGroups={"categoria"}, serializerEnableMaxDepthChecks= true)
     */
    public function createCategoria(Request $request){

        $categoria = new Categoria();
        //Crear un form, este recibe dos argumentos:
        // el tipo formulario, y el objeto al que va asociado
        $form = $this->createForm(CategoriaFormType::class, $categoria);
        // le decimos al formulario que maneje la request
        $form->handleRequest($request);

        // comprobar que se ha submiteado y si es valido
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($categoria);
            $this->em->flush();
            return $categoria;
        }

        return $form;


    }


    /**
     * @Rest\Post(path="/restaurante/categoria")
     * @Rest\View (serializerGroups={"categoria_restaurante"}, serializerEnableMaxDepthChecks= true)
     */

    public function restauranteAddCategoria(Request $request, RestauranteRepository $restauranteRepository){
        $res = $request->get('restaurante');
        $categorias = $request->get('categorias');
        $restaurante = $restauranteRepository->find($res);
        foreach ($categorias as $cat){
            $categoria =$this->catRepository->find($cat);
            if(!$cat){
                return new Response('Not found', Response::HTTP_NOT_FOUND);
            }
            $restaurante->addCategoria($categoria);
        }
        $this->em->persist($restaurante);
        $this->em->flush();
        return $restaurante;
    }

    /**
     * @Rest\Post (path="/categorias/remove/restaurante")
     * @Rest\View (serializerEnableMaxDepthChecks=true)
     */

    public function removeCategoriaRestaurante(Request $request,  RestauranteRepository $restauranteRepository){
        $categoria = $request-> get('categoria');
        $restaurante = $request-> get('restaurante');

        if(!$categoria || !$restaurante){
            return new Response( 'Bad request', Response::HTTP_BAD_REQUEST);
        }

        $restaurante = $restauranteRepository->find($restaurante);
        $categoria = $this->catRespository->find($categoria);

        if(!$categoria || !$restaurante){
         return  new Response('Not found', Response::HTTP_NOT_FOUND);
        }

        $restaurante->removeCategoria($categoria);
        $this->em->persist($restaurante);
        $this->em->flush();
        return new Response('ok', Response::HTTP_OK);
    }

}