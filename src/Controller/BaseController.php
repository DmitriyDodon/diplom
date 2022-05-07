<?php

namespace App\Controller;

use App\Service\CartItem\CartItemFactory;
use App\Service\Order\OrderManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class BaseController extends AbstractController
{
    private const ITEMS_PER_PAGE = 20;

    private Request $request;
    private PaginatorInterface $paginator;
    private EntityManagerInterface $em;
    protected CartItemFactory $cartItemFactory;
    protected OrderManager $orderManager;

    public function __construct(
        RequestStack $requestStack,
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
        CartItemFactory $cartItemFactory,
        OrderManager $orderManager
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->paginator = $paginator;
        $this->em = $em;
        $this->cartItemFactory = $cartItemFactory;
        $this->orderManager = $orderManager;
    }


    public function getPaginated(Query $query)
    {
        return $this->paginator->paginate(
            $query,
            $this->request->get('page', 1),
            $this->request->get('items_per_page', self::ITEMS_PER_PAGE)
        );
    }

    public function getRepository(string $entityClassName)
    {
        return $this->em->getRepository($entityClassName);
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function flushEntities()
    {
        $this->em->flush();
    }

}