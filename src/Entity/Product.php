<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le brand  est obligatoire !")
     * @Assert\Length(min=2, max=255, minMessage="Le brand  doit avoir plus de 4 caractères !")
     * @SWG\Property(type="string")
     * @var string
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le model  est obligatoire !")
     * @Assert\Length(min=2, max=255, minMessage="Le model  doit avoir plus de 4 caractères !")
     * @SWG\Property(type="string")
     * @var string
     */
    private $model;

   /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="L'année est obligatoire !")
     * @SWG\Property(type="integer")
     * @var integer
     */
    private $releaseYear;

     /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La couleur  est obligatoire !")
     * @Assert\Length(min=2, max=255, minMessage="Le couleur  doit avoir plus de 4 caractères !")
     * @SWG\Property(type="string")
     * @var string
     */
    private $color;

      /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le pixel  est obligatoire !")
     * @SWG\Property(type="float")
     * @var float
     */
    private $screenSize;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le pixel  est obligatoire !")
     * @SWG\Property(type="integer")
     * @var integer
     */
    private $storageGB;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le giga  est obligatoire !")
     * @SWG\Property(type="integer")
     * @var integer
     */
    private $memoryGB;

   /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le mega giga  est obligatoire !")
     * @SWG\Property(type="integer")
     * @var integer
     */
    private $megapixels;

   /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le prix  est obligatoire !")
     * @SWG\Property(type="float")
     * @var float
     */
    private $price;

    private $_links;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     */
    private $userClient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getScreenSize(): ?float
    {
        return $this->screenSize;
    }

    public function setScreenSize(float $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getStorageGB(): ?int
    {
        return $this->storageGB;
    }

    public function setStorageGB(int $storageGB): self
    {
        $this->storageGB = $storageGB;

        return $this;
    }

    public function getMemoryGB(): ?int
    {
        return $this->memoryGB;
    }

    public function setMemoryGB(int $memoryGB): self
    {
        $this->memoryGB = $memoryGB;

        return $this;
    }

    public function getMegapixels(): ?int
    {
        return $this->megapixels;
    }

    public function setMegapixels(int $megapixels): self
    {
        $this->megapixels = $megapixels;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getUserClient(): ?User
    {
        return $this->userClient;
    }

    public function setUserClient(?User $userClient): self
    {
        $this->userClient = $userClient;

        return $this;
    }
}
