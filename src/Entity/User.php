<?php

namespace App\Entity;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Person;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
     /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    
     /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Le username est obligatoire !")
     * @Assert\Length(min=2, max=255, minMessage="Le username doit avoir plus de 4 caractères !")
     * @SWG\Property(type="string")
     * @var string
     */
    private $username;
   
      /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Le email est obligatoire !")
     * @Assert\Length(min=2, max=255, minMessage="Le email doit avoir plus de 5 caractères !")
     * @SWG\Property(type="string")
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

     /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le mot de passe est obligatoire !")
     * @SWG\Property(type="string")
     * @var string The hashed password
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="userClient")
     */
    private $people;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="userClient")
     */
    private $products;
    private $_links;
    private $userClient;
    public function __construct()
    {
        $this->people = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


     public function getUserClient(): ?Person
    {
        return $this->userClient;
    }

    public function setUserClient(?Person $userClient): self
    {
        $this->userClient = $userClient;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getEmail(): string
    {
        return (string) $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
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




    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setUserClient($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getUserClient() === $this) {
                $person->setUserClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUserClient($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getUserClient() === $this) {
                $product->setUserClient(null);
            }
        }

        return $this;
    }
}
