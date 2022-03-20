<?php

namespace App\Service\User;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class UserService
{
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(
        Security $security
    )
    {
        $this->security = $security;
    }

    public function getUser(): ?User
    {
        $user = $this->security->getUser();
        if ($user instanceof User) {
            return $user;
        }

        return null;
    }

}