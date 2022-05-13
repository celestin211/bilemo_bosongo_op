<?php

namespace App\DTO;

use App\Entity\User;
use App\Entity\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class UserDTO
{

  private $id;
  private $username;
  private $roles = [];
  private $password;
  private $email;
  private $_links;
  private $userClient;

    public function __construct(
        User $user
    ) {
        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->password = $user->getPassword();
        $this->email = $user->getEmail();
        $this->roles = $user->getRoles();
        $this->userClient = $user->getUserClient();
    }

    public function getUserDTO(array $users)
    {
        foreach ($users as $user) {
            $userDTO = new self($user);
            $usersDTO[] = $userDTO;
        }

        return $usersDTO;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function get_Links(): ?array
    {
        return $this->_links;
    }

    public function set_Links(array $links): self
    {
        $this->_links = $links;

        return $this;
    }


}
