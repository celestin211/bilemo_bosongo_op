<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

     /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse email ne doit pas être vide !")
     * @SWG\Property(type="string")
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le firstname ne doit pas être vide !")
     * @SWG\Property(type="string")
     * @var string
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="people")
     */
    private $userClient;

    private $_links;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUserClient(): ?User
    {
        return $this->userClient;
    }

    public function setUserClient(?User $userClient): self
    {
        $this->userClient = $userClient;

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
