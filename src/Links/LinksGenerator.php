<?php

namespace App\Links;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LinksGenerator
{


    public function __construct
    (
        protected readonly  UrlGeneratorInterface $urlGenerator
    )
    {

    }

    public function addLinks($datas)
    {
        if (is_array($datas)) {
            foreach ($datas as $object) {
                $this->createLinks($object);
            }

            return;
        }
        $this->createLinks($datas);

        return;
    }
}
