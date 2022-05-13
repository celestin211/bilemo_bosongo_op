<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Links\LinksProductDTOGenerator;
use App\Paging\ProductsPaging;
use App\Responder\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListOfProductsController
{
    private $responder;
    private $paging;
    private $productDTO;
    private $links;

    public function __construct(
        JsonResponder $responder,
        ProductsPaging $paging,
        ProductDTO $productDTO,
        LinksProductDTOGenerator $links
    ) {
        $this->responder = $responder;
        $this->paging = $paging;
        $this->productDTO = $productDTO;
        $this->links = $links;
    }

    /**
     * @Route("/product", methods={"GET"}, name="listOfProducts")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return list of product",
     *
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Error : The page must be between X and X."
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="Product pagination"
     * )
     * @SWG\Tag(name="Product")
     * @SecurityDoc(name="Bearer")
     */
    public function listOfproduct(Request $request)
    {
        $products = $this->paging->getDatas($request->query->get('page'));

        $productsDTO = $this->productDTO->getProductDTO($products);

        $this->links->addLinks($productsDTO);

        return $this->responder->send($request, $productsDTO);
    }
}
