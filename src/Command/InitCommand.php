<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitCommand extends Command
{
    protected static $defaultName = 'app:init';
    protected static $defaultDescription = 'Init app';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $stockCommand = $this->getApplication()->find('app:init-stocks');
        $adminCommand = $this->getApplication()->find('app:make-admin');
        $parseProductCommand = $this->getApplication()->find('app:parse-products');
        $migrationCommand = $this->getApplication()->find('doctrine:migrations:migrate');

        $adminCommandArguments = [
            'userName' => 'test@gamil.com',
            'password' => '12345678'
        ];


        $migrationCommand->run(new ArrayInput([]), $output);
        $returnStockCommand = $stockCommand->run(new ArrayInput([]), $output);
        $returnAdminCommand = $adminCommand->run(new ArrayInput($adminCommandArguments), $output);
        $returnParseProductCommand = $parseProductCommand->run(new ArrayInput([]), $output);

        $io->success('App inited.');

        return Command::SUCCESS;
    }
}
