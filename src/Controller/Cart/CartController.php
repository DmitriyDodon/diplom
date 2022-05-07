<?php

namespace App\Controller\Cart;

use App\Controller\BaseController;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Service\Cart\CartFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 * @IsGranted("ROLE_USER")
 */
class CartController extends BaseController
{
    /**
     * @Route("/product/add/{product}", name="add_product_to_cart")
     */
    public function addProductToCart(
        Product $product,
        CartFactory $cartFactory
    )
    {
        /** @var Cart $cart */
        $cart = $this->getUser()->getCart();
        if (null === $cart){
            $cartFactory->createCart($this->getUser());
        }
        $cartItem = $this->cartItemFactory->createCartItem($product, $cart);
        $cart->addItem($cartItem);
        $this->getEntityManager()->flush();
        return $this->redirectToRoute('app_product_index');
    }

    /**
     * @Route("/", name="cart_index")
     */
    public function index()
    {
        return $this->render(
            'cart/index.twig',
            [
                'cartItems' => $this->getPaginated(
                    $this->getRepository(CartItem::class)->getAllItemsByCart($this->getUser()->getCart())
                )
            ]
        );
    }
}