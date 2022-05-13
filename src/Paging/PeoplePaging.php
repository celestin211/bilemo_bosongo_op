<?php

namespace App\Paging;

use App\Exceptions\ApiException;
use App\Repository\PersonRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class PeoplePaging
{
    private const NB_PEOPLE_PAGED = 5;
    private $personRepository;
    private $security;
    private $nbPeople;
    private $maxPages;

    public function __construct(
      PersonRepository $personRepository

    ) {
        $this->personRepository = $personRepository;
        $this->nbPeople = $this->personRepository->count([]);
        $this->maxPages = intval(ceil($this->nbPeople / self::NB_PEOPLE_PAGED));
    }

    public function getDatas($page)
    {
        if (null === $page) {
            return $people = $this->personRepository->findAll();
        }

        if (1 > $page || $page > $this->maxPages) {
            throw new ApiException('The page must be between 1 and '.$this->maxPages.'.', 404);
        }

        $offset = self::NB_PEOPLE_PAGED * ($page - 1);

        return $people = $this->personRepository->findBy([], [], self::NB_PEOPLE_PAGED, $offset);
    }
}
