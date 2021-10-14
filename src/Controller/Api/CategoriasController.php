<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\Type\CategoriaFormType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

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

}