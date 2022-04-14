<?php

namespace App\Command;

use ParseCsv\Csv;
use ParseCsv\enums\FileProcessingModeEnum;
use PHPHtmlParser\Dom;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParseCatalogCommand extends Command
{
    protected static $defaultName = 'app:parse-catalog';
    protected static $defaultDescription = 'Add a short description for your command';

    private $client;
    private $csv;
    private $projectRoot;

    public function __construct(ContainerBagInterface $containerBag, HttpClientInterface $client, string $name = null)
    {
        $this->projectRoot = $containerBag->get('kernel.project_dir');
        $this->csv = new Csv();
        $this->client = $client;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $response = $this->client->request(
            'GET',
            'https://www.tavriav.ua/'
        );

        $html = $response->getContent();

        $crawler = new Crawler($html);

        $data = $crawler->filterXPath('//div[@class="megadrop"] //ul //li //a')->extract(['href']);

        foreach ($data as $url) {
            $i = 0;
            $url = 'https://www.tavriav.ua' . $url;
            while (true) {
                $i++;
                try {
                    $response = $this->client->request(
                        'GET',
                        $url . '?page=' . $i
                    );
                    $io->success('Passed url: ' . $url . '?page=' . $i);
                } catch (TransportExceptionInterface $e) {
                    $io->error('Failed url: ' . $url . PHP_EOL . 'Reason: ' . $e->getMessage());
                    $this->logError(
                        $url . '?page=' . $i,
                        $i,
                        null,
                        $e->getMessage()
                    );
                    continue;
                }

                try {
                    if ($response->getStatusCode() !== 200) {
                        break;
                    }
                } catch (TransportExceptionInterface $e) {
                    $io->error($url . '?page=' . $i . ' ' . $e->getMessage());
                    $this->logError(
                        $url . '?page=' . $i,
                        $i,
                        null,
                        $e->getMessage()
                    );
                    break;
                }

                try {
                    $html = $response->getContent();
                } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
                    $io->error($url . '?page=' . $i . ' ' . $e->getMessage());
                    $this->logError(
                        $url . '?page=' . $i,
                        $i,
                        null,
                        $e->getMessage()
                    );
                    break;
                }

                $crawler = new Crawler($html);

                $categoryName = $crawler->filterXPath('//div[@class="catalog-products__headline"] //h3')->text();

                $data = $crawler->filterXPath('//div[@class="product__quick-view"]')->extract(
                    ['data-title', 'data-price', 'data-thumbs']
                );

                if (empty($data)) {
                    break;
                }

                $data[] = $categoryName;
                $products = [];

                foreach ($data as $product) {
                    if (isset($product[2]) && $image = explode(',', $product[2])[0] ?? null) {
                        $products[] = [
                           $product[0],
                           $product[1],
                           $image,
                           $categoryName
                        ];
                    } else {
                        $products[] = [
                           $product[0],
                           $product[1],
                           '',
                           $categoryName
                        ];
                    }
                }

                try {
                    $this->csv->save(
                        $this->projectRoot . '/data/data-tables/products/products.csv',
                        $products,
                        FileProcessingModeEnum::MODE_FILE_APPEND
                    );
                } catch (\ErrorException $e) {
                    $io->error($url . ' ' . $e->getMessage());
                    $this->logError(
                        $url . '?page=' . $i,
                        $i,
                        $categoryName,
                        $e->getMessage()
                    );
                }
            }
        }
        $io->success('Parsed all.');
        return Command::SUCCESS;
    }


    private
    function logError(
        ?string $url,
        ?int $page,
        ?string $category,
        ?string $reason
    ) {
        $json_data = json_encode([
            'url' => $url,
            'reason' => $reason,
            'category' => $category,
            'page' => $page
        ]);
        $fp = fopen($this->projectRoot . '/data/data-tables/errors.json', 'a');//opens file in append mode
        fwrite($fp, $json_data . PHP_EOL);
        fclose($fp);
    }
}
