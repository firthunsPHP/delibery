<?php


namespace App\Controller;


use App\Entity\Categoria;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends  AbstractController
{
// composer require logger -> instalacion realizada

    private $logger;
    public  function  __construct(LoggerInterface $logger){ // constructor

        $this->logger = $logger;
    }

    // Con la anotación Route establecemos el endpoint
    /**
     * @Route("/categoria/list" , name="categoria_list" )
     */

// Método asociado al endpoint, siempre tiene que devolver un respones
    public  function listCategorias(Request $request, CategoriaRepository $categoriaRepository ){
//        $response = new Response();
//        $response->setContent('<div> Hola Mundo</div>');
//        return $response;

        $categoria = $categoriaRepository->findAll();

        // antes de montar el json, capturamos el contenido del request
        //        127.0.0.1:8000/categoria/list?categoria=Indu


        $categoria = $request->get('categoria');
        $response = new JsonResponse();
        $response-> setData([
            'success' => true,
            'data' =>  [
                [
                    'id' => 1,
                    'categoria' => 'Japones'
                ],
                [
                    'id' => 2,
                    'categoria' => 'Italiano'
                ],
                [
                    'id' => 2,
                    'categoria' => $categoria
                ],
            ]
        ]);

        $this->logger->info('List categorias matched!!!!');
//     el resultado lo veriamos en el directorio var>log> dev.log
        return $response;
    }


    /**
     * @Route ("/categoria", name="create_categoria")
     */

    public function  crearCategoria(Request $request, EntityManagerInterface  $em){

        $nombre = $request->get('categoria');
        $response = new JsonResponse();

   // comprobamos que el nombre no exista
        if(!$nombre){
            $response->setData([
                'success' => false,
                'data' => null,
                'error'=> 'Categoria name can´t be bull'
            ]);
            return $response;
        }

        $categoria = new Categoria();
        $categoria->setCategoria($nombre);
        //como lo guardo en BD?
        //Persist no lo guarda, le dice a doctrine que haga lo que tenga que hacer
        // para prepararlo para base de datos.
        $em-> persist($categoria);
        $em->flush();
        //devolver una respuesta

        $response-> setData([
            'succes' => true,
            'data' => [
                [
                    'id'=> $categoria->getId(),
                    'categoria' =>$categoria->getCategoria(),
                ]
            ]
        ]);
        return $response;
    }



}