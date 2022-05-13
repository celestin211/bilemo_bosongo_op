<?php

namespace App\DTO;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class ProductDTO
{
  private $id;
  private $brand;
  private $model;
  private $releaseYear;
  private $color;
  private $screenSize;
  private $storageGB;
  private $memoryGB;
  private $megapixels;
  private $price;
  private $_links;

    public function __construct(
        Product $product
    ) {
        $this->id = $product->getId();
        $this->brand = $product->getBrand();
        $this->model = $product->getModel();
        $this->releaseYear = $product->getReleaseYear();
        $this->memoryGB = $product->getMemoryGB();
        $this->color = $product->getColor();
        $this->megapixels = $product->getMegapixels();
        $this->price = $product->getPrice();
        $this->storageGB = $product->getStorageGB();
        $this->screenSize = $product->getScreenSize();
        $this->_links = $product->get_links();
    }

    public function getProductDTO(array $products)
    {
      foreach ($products as $product) {
          $productDTO = new self($product);
          $productsDTO[] = $productDTO;
      }


        return $productsDTO;
    }

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
