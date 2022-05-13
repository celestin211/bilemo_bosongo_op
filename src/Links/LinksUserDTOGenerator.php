<?php

namespace App\Links;

class LinksUserDTOGenerator extends LinksGenerator
{
  protected function createLinks(object $object)
  {
      $object->set_links(['self' => $this->urlGenerator->generate('detailsUser', ['id' => $object->getId()], 0),
                          'list' => $this->urlGenerator->generate('listOfUser', [], 0),
                          'add' => $this->urlGenerator->generate('addUser', [], 0),
                          'delete' => $this->urlGenerator->generate('deletelUser', ['id' => $object->getId()], 0)
      ]);
  }
}
