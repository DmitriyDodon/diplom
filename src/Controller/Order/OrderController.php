<?php

namespace App\Controller\Order;

use App\Controller\BaseController;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Form\CreateOrderType;
use App\Service\Cart\CartFactory;
use App\Service\Cart\CartManager;
use App\Service\Order\OrderFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 * @IsGranted("ROLE_USER")
 */
class OrderController extends BaseController
{
    /**
     * @Route("/", name="create_order_from_cart")
     */
    public function createOrder(Request $request, OrderFactory $orderFactory, CartFactory $cartFactory, CartManager $cartManager)
    {

        $cart = $this->getUser()->getCart();

        if (null === $cart){
            $cartFactory->createCart($this->getUser());
            return $this->redirectToRoute('index');
        }

        $order = $orderFactory->createOrder($cart);

        $form = $this->createForm(CreateOrderType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $cartManager->deleteAllItemsFromCart($cart);
            $this->flushEntities();
            return $this->redirectToRoute('index');
        }
        return $this->render('order/create.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/list", name="create_order_list")
     */
    public function getAllUsersOrders()
    {
        return $this->render('order/orders-list.twig', [
            'orders' => $this->getPaginated($this->getRepository(Order::class)->getOrdersByUser($this->getUser()))
        ]);
    }

    /**
     * @Route("/remove/{order}/{orderItem}", name="remove_order_item")
     */
    public function removeOrderItem(Order $order, OrderItem $orderItem)
    {
        $this->getRepository(OrderItem::class)->remove($orderItem);
        return $this->redirectToRoute('show_order',['orderId' => $order->getId()]);
    }

    /**
     * @Route("/show/{orderId}", name="show_order")
     */
    public function showOrder(Order $orderId)
    {
        $order = $this->getRepository(Order::class)->getOrderWithItems($orderId->getId());
        $this->orderManager->getRightValuesForOrder($orderId);
        return $this->render('order/show.twig',[
            'order' => $order[0]
        ]);
    }

    /**
     * @Route("/order/{order}/set/order/payed")
     * @IsGranted("ROLE_ADMIN")
     */
    public function setStatusPayed(Order $order)
    {
        $order->setStatus(1);
        return $this->redirectToRoute('show_order', ['orderId' => $order->getId()]);
    }

    /**
     * @Route("/order/invoice/{order}", name="get_order_ivoice")
     */
    public function getOrderInvoice(Order $order)
    {
        $html = $this->renderView('order/invoice/invoice.twig',['order' => $order]);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        ob_get_clean();
        $dompdf->stream("Order_invoice_" . $order->getId() . ".pdf");

    }
}