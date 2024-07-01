<?php

namespace App\Command;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:hash-employee-mdp',
    description: 'hash',
)]
class HashEmployeeMdpCommand extends Command
{
    private $em;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $employees = $this->em->getRepository(Employee::class)->findAll();

        $count = 0;
        foreach ($employees as $employee) {
            $plainPassword = $employee->getMdp();
            $hashedPassword = $this->passwordHasher->hashPassword($employee, $plainPassword);
            $employee->setMdp($hashedPassword);
            $count++;
        }

        $this->em->flush();

        $io->success(sprintf('Les mdps ont etaient hashe sans probleme.', $count));

        return Command::SUCCESS;
    }
}
