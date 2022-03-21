<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 * @IsGranted("ROLE_MANAGER")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/", name="get_users_list")
     */
    public function getUsersList(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->getUsersPaginated();
        return $this->render('user/list/index.html.twig',[
            'users' => $users
        ]);
    }

}