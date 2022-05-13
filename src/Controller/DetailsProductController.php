<?php

namespace App\Controller;

use App\Exceptions\ApiException;
use App\Links\LinksProductDTOGenerator;
use App\Repository\ProductRepository;
use App\Responder\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetailsProductController
{
    private $productRepository;
    private $responder;

    public function __construct(
        ProductRepository $productRepository,
        JsonResponder $responder,
        LinksProductDTOGenerator $links
    ) {
        $this->productRepository = $productRepository;
        $this->responder = $responder;
        $this->links = $links;
    }

    /**
     * @Route("/product/{id}", methods={"GET"}, name="detailsProduct")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one product",
     *
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Error : This product not exist.",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the product"
     * )
     * @SWG\Tag(name="Product")
     * @SecurityDoc(name="Bearer Token")
     */
    public function detailsProduct($id, Request $request)
    {
        $product = $this->productRepository->findOneById($id);
        if (null == $product) {
            throw new ApiException('This product not exist.', 404);
        }

        $this->links->addLinks($product);

        return $this->responder->send($request, $product);
    }
}
