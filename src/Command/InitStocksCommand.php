<?php

namespace App\Command;

use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitStocksCommand extends Command
{
    private const QUANTITY_OF_STOCK = 10;

    protected static $defaultName = 'app:init-stocks';
    protected static $defaultDescription = 'Add a short description for your command';
    private EntityManagerInterface $em;
    private Generator $faker;

    public function __construct(
        EntityManagerInterface $em,
        string $name = null
    )
    {
        $this->faker = Factory::create();
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Quantity of stocks.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $quantityOfStocks = $input->getArgument('arg1') ?? self::QUANTITY_OF_STOCK;

        for($i = 0; $i < $quantityOfStocks; $i++){
            $stock = new Stock();
            $stock->setAddress(
                $this->faker->address()
            );
            $this->em->persist($stock);
            if ($i === 5) $this->em->flush();
        }
        $this->em->flush();


        $io->success($quantityOfStocks . ' stocks added.');

        return Command::SUCCESS;
    }
}
