<?php

namespace App\Paging;

use App\Exceptions\ApiException;
use App\Repository\UserRepository;

class UserPaging
{
    private const NB_PRODUCTS_PAGED = 5;

    private $userRepository;
    private $nbUsers;
    private $maxPages;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
        $this->nbUsers = $this->userRepository->count([]);
        $this->maxPages = intval(ceil($this->nbUsers / self::NB_PRODUCTS_PAGED));
    }

    public function getDatas($page)
    {
        if (null === $page) {
            return $user = $this->userRepository->findAll();
        }

        if (1 > $page || $page > $this->maxPages) {
            throw new ApiException('The page must be between 1 and '.$this->maxPages.'.', 404);
        }

        $offset = self::NB_PRODUCTS_PAGED * ($page - 1);

        return $users = $this->userRepository->findBy([], [], self::NB_PRODUCTS_PAGED, $offset);
    }
}
