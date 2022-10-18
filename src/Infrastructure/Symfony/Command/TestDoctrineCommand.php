<?php

namespace App\Infrastructure\Symfony\Command;

use App\Repository\SpaceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test-doctrine',
    description: 'Add a short description for your command',
)]
class TestDoctrineCommand extends Command
{
    public function __construct(
        private SpaceRepository $spaceRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('spaceId', InputArgument::REQUIRED, 'Space ID')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->em->beginTransaction();
        $spaceId = $input->getArgument('spaceId');
        $space = $this->spaceRepository->find($spaceId);
        $space->setName('NUEVO NOMBRE');
        $this->em->flush();

        $users = $this->userRepository->findAll(['name' => 'ASC']);
        foreach ($users as $user) {
            $this->em->remove($user);
        }

        $spaces = $this->spaceRepository->findBy(['alias' => 'space-462'], ['name' => 'ASC']);
        foreach ($spaces as $space2) {
            $output->writeln($space2->getName());
        }

        $space3 = $this->spaceRepository->findOneBy(['name' => 'fszfr-22588']);
        $output->writeln($space3->getAlias());
        foreach ($space3->getProjects() as $project) {
            $output->writeln('- ' . $project->getName());
        }

        

        $this->em->flush();
        $this->em->commit();

        if ($space == null) {
            $output->writeln('No encontrado: ' . $spaceId);
        } else {
            $output->writeln($space->getName());
        }
        return Command::SUCCESS;
    }
}
