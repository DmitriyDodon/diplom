<?php

namespace App\Command;

use App\Entity\Category;
use Ausi\SlugGenerator\SlugGenerator;
use Ausi\SlugGenerator\SlugOptions;
use Doctrine\ORM\EntityManagerInterface;
use ParseCsv\Csv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CreateCategoryCommand extends Command
{
    protected static $defaultName = 'app:create-category';

    protected static $defaultDescription = 'Add categories to data base';

    private SlugGenerator $slugger;

    private Csv $csv;

    private string $projectRoot;

    private EntityManagerInterface $em;

    public function __construct(ContainerBagInterface $containerBag, EntityManagerInterface $em, string $name = null)
    {
        $this->projectRoot = $containerBag->get('kernel.project_dir');;
        $this->slugger = new SlugGenerator((new SlugOptions)->setValidChars('a-zA-Z0-9')->setLocale('en')->setDelimiter('_'));
        parent::__construct($name);
        $this->csv = new Csv();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->csv->parseFile($this->projectRoot . '/data/data-tables/categories/categories.csv');

        $i = 0;
        foreach ($this->csv->data as $row){
            $i++;
            $category = new Category();
            $category->setTitle($row['Dairy products']);
            $category->setSlug($this->slugger->generate($row['Dairy products']));
            $this->em->persist($category);
            if($i%20===0){$this->em->flush();}
            $io->text('Category ' . $row['Dairy products'] . ' added.' . PHP_EOL);
        }

        $io->success('All categories added.');

        return Command::SUCCESS;
    }
}
