<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\ProductStock;
use App\Entity\Stock;
use App\Entity\User;
use App\Service\Category\CategoryFactory;
use App\Service\Product\ProductFactory;
use Ausi\SlugGenerator\SlugGenerator;
use Ausi\SlugGenerator\SlugGeneratorInterface;
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

class ParseProductsCommand extends Command
{
    protected static $defaultName = 'app:parse-products';
    protected static $defaultDescription = 'Add a short description for your command';
    private string $dataSheetFilePath;
    private Csv $csv;
    private EntityManagerInterface $em;
    private CategoryFactory $categoryFactory;
    private ProductFactory $productFactory;
    private SlugGeneratorInterface $slugGenerator;

    public function __construct(
        ContainerBagInterface $containerBag,
        EntityManagerInterface $em,
        CategoryFactory $categoryFactory,
        ProductFactory $productFactory,
        string $name = null)
    {
        $this->csv = new Csv();
        $this->slugGenerator = new SlugGenerator((new SlugOptions)->setValidChars('a-zA-Z0-9')->setLocale('ua')->setDelimiter('_'));
        $this->dataSheetFilePath = $containerBag->get('kernel.project_dir') . '/data/data-tables/products/products.csv';
        parent::__construct($name);
        $this->em = $em;
        $this->categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $csvSource = fopen($this->dataSheetFilePath, 'rb+');

        $i = 0;

        $users = $this->em->getRepository(User::class)->findAll();
        $user = end($users);

        if(!$user instanceof User) {
            throw new \RuntimeException('There is no users yet');
        }

        $stocks = $this->em->getRepository(Stock::class)->findAll();


        while (($product = fgetcsv($csvSource, '', ",")) !== FALSE)
        {
            $i++;
            if ($product[0] === '') {
                continue;
            }
            $category = $this->em->getRepository(Category::class)->findOneBy(['slug' => $this->slugGenerator->generate($product[3])]) ??
                $this->categoryFactory->createCategory($product[3]);

            $product = $this->productFactory->createProduct(
                $product[0],
                (float)$product[1],
                $product[2] ?? null,
                $user,
                $category
            );

            $productStock = new ProductStock();
            $productStock->setStock($stocks[array_rand($stocks)]);
            $productStock->setProduct($product);
            $productStock->setQuantity(random_int(1000, 2000));
            $this->em->persist($productStock);
            $this->em->flush();
            $io->text($product->getTitle() . ' added to database');
            if ($i % 70 === 0)sleep(2);
            if ($i === 2000) break;
        }

        fclose($csvSource);


        $io->success('All products parsed');

        return Command::SUCCESS;
    }
}
