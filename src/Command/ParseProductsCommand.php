<?php

namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use ParseCsv\Csv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ParseProductsCommand extends Command
{
    protected static $defaultName = 'app:parse-products';
    protected static $defaultDescription = 'Add a short description for your command';
    private string $dataSheetFilePath;
    private Csv $csv;
    private EntityManagerInterface $em;

    public function __construct(
        ContainerBagInterface $containerBag,
        EntityManagerInterface $em,
        string $name = null)
    {
        $this->csv = new Csv();
        $this->dataSheetFilePath = $containerBag->get('kernel.project_dir') . '/data/data-tables/products/products.csv';
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $products = $this->csv->parseFile($this->dataSheetFilePath);

        foreach ($products as $product)
        {
            $category = $this->em->getRepository(Category::class)->findOneBy(['title' => $product]);
        }


        $io->success('All products parsed');

        return Command::SUCCESS;
    }
}
