<?php

namespace App;

use Doctrine\ORM\EntityManagerInterface;

class access
{
    private $entityManager;

    public function __construct(EntityManagerInterface $accessEntityManager)
    {
        $this->entityManager = $accessEntityManager;
    }

    public function fetchData()
    {
        $repository = $this->entityManager->getRepository('App\Entity\Access');
        return $repository->findAll();
    }
}
