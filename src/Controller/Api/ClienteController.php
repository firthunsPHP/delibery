<?php

namespace App\Controller\Api;

use App\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClienteController extends AbstractApiController
{
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface  $em, ClienteRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

}