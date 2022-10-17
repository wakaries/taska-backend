<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:set-password',
    description: 'Add a short description for your command',
)]
class SetPasswordCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository, 
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('password', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userRepository->findOneBy(['username' => $input->getArgument('username')]);
        $hashedPassword = $this->hasher->hashPassword(
            $user,
            $input->getArgument('password')
        );
        $user->setPassword($hashedPassword);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
