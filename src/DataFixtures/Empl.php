<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Empl extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $employee = new Employee();
        $employee->setEmail('franck.pringue@flipo-richir.com');
        $employee->setMdp('Badm!tt0n');

        $manager->persist($employee);

        $employee1 = new Employee();
        $employee1->setEmail('nicolas.lefbvre@flipo-richir.com');
        $employee1->setMdp('Non-Badm!tt0n');

        $manager->persist($employee1);

        $employee2 = new Employee();
        $employee2->setEmail('olivier.nomdedeu@flipo-richir.com');
        $employee2->setMdp('N@tat!0n');

        $manager->persist($employee2);

        $manager->flush();
    }
}
