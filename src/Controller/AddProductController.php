<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Links\LinksProductDTOGenerator;
use App\Responder\JsonResponder;
use App\Security\ErrorsValidator;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddProductController
{
    private $serializer;
    private $manager;
    private $security;
    private $validator;
    private $errorsValidator;
    private $responder;
    private $links;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $manager,
        Security $security,
        ValidatorInterface $validator,
        ErrorsValidator $errorsValidator,
        JsonResponder $responder,
        LinksProductDTOGenerator $links
    ) {
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->security = $security;
        $this->validator = $validator;
        $this->errorsValidator = $errorsValidator;
        $this->responder = $responder;
        $this->links = $links;
    }

    /**
     * @Route("/product", methods={"POST"}, name="addProduct")
     * * @SWG\Response(
     *     response=201,
     *     description="Returns the created person",
     * )
     * @SWG\Response(
     *     response=409,
     *     description="Invalid : Return all fields with an error",
     * )
     * @SWG\Parameter(
     *     name="Product",
     *     in="body",
     *     description="The person you want add",
     *     @SWG\Schema(
     *         @SWG\Property(property="model", type="string", example="Apple"),
     *         @SWG\Property(property="brand", type="string", example="iPhone 6S"),
     *         @SWG\Property(property="color", type="string", example="Space Gray"),
     *         @SWG\Property(property="price", type="float", example="456,45"),
     *         @SWG\Property(property="releaseYear", type="float", example="2015"),
     *         @SWG\Property(property="storageGB", type="integer", example="32"),
     *         @SWG\Property(property="memoryGB", type="float", example="2015"),
     *         @SWG\Property(property="screenSize", type="integer", example="3.5"),
     *         @SWG\Property(property="megapixels", type="integer", example="15")
     *     )
     * )
     * @SWG\Tag(name="Product")
     * @SecurityDoc(name="Bearer")
     */
    public function addProduct(Request $request)
    {
      $product = $this->serializer->deserialize($request->getContent(), Product::class, 'json');

      $errors = $this->validator->validate($product);
      if (count($errors) > 0) {
          return $this->responder->send($request, $this->errorsValidator->arrayFormatted($errors), 409);
      }


        $this->manager->persist($product);
        $this->manager->flush();
        $productDTO = new ProductDTO($product);
        $this->links->addLinks($productDTO);

        return $this->responder->send($request, $productDTO, 201);
    }
}
