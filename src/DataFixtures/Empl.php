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
        

        $employee3 = new Employee();
        $employee3->setEmail('christophe.debendere@flipo-richir.com');
        $employee3->setMdp('Fo0tb@1l');

        $manager->persist($employee3);

        $employee4 = new Employee();
        $employee4->setEmail('justyna.kaniuczak@flipo-richir.com');
        $employee4->setMdp('Mar@th0n');

        $manager->persist($employee4);

        $employee5 = new Employee();
        $employee5->setEmail('pascal.lemaire@flipo-richir.com');
        $employee5->setMdp('Pet@nquE');

        $manager->persist($employee5);

        $employee6 = new Employee();
        $employee6->setEmail('laurent.paque@flipo-richir.com');
        $employee6->setMdp('Badm!tt0n');

        $manager->persist($employee6);

        $employee7 = new Employee();
        $employee7->setEmail('freddy.dufour@flipo-richir.com');
        $employee7->setMdp('Non-Badm!tt0n');

        $manager->persist($employee7);

        $employee8 = new Employee();
        $employee8->setEmail('catherine.legros@flipo-richir.com');
        $employee8->setMdp('N@tat!0n');

        $manager->persist($employee8);



        $manager->flush();
    }
}
