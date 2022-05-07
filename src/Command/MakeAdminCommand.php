<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MakeAdminCommand extends Command
{
    protected static $defaultName = 'app:make-admin';
    protected static $defaultDescription = 'Creating new admin';
    private UserPasswordHasher $userPasswordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        string $name = null
    ) {
        parent::__construct($name);
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('userName', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('password', InputArgument::REQUIRED, 'Argument description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userName = $input->getArgument('userName');
        $password = $input->getArgument('password');

        $user = new User();
        $user->setUsername($userName);
        $user->setUniqueKey(mb_strimwidth(str_shuffle(uniqid('', true) . uniqid('', true)), 0, 12));
        $user->setRegisteredAt(new \DateTime());
        $user->setIsAdmin(true);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $password
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();


        $io->success('Admin created' . PHP_EOL . 'Login ' . $userName . PHP_EOL . 'Password ' . $password);

        return Command::SUCCESS;
    }
}
