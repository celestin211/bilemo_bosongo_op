<?php

namespace App\Controller;

use App\Exceptions\ApiException;
use App\Repository\ProductRepository;
use App\Responder\JsonResponder;
use App\Security\Voter\ProductVoter;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DeleteProductController
{
    private $manager;
    private $security;
    private $productRepository;
    private $productVoter;
    private $responder;

    public function __construct(
        EntityManagerInterface $manager,
        Security $security,
        ProductRepository $productRepository,
        ProductVoter $productVoter,
        JsonResponder $responder
    ) {
        $this->manager = $manager;
        $this->security = $security;
        $this->productRepository = $productRepository;
        $this->productVoter = $productVoter;
        $this->responder = $responder;
    }

    /**
     * @Route("/product/{id}", methods={"DELETE"}, name="deleteProduct")
     * @SWG\Response(
     *     response=204,
     *     description="product was deleted ",
     *
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Error : This person not exist.",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Error : You are not authorized to access this resource..",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the person"
     * )
     * @SWG\Tag(name="Product")
     * @SecurityDoc(name="Bearer")
     */

    public function deleteProduct($id, Request $request)
    {
        $product = $this->productRepository->findOneById($id);

        if (null == $product) {
            throw new ApiException('This product not exist.', 404);
        }


        $this->manager->remove($product);
        $this->manager->flush();

        return $this->responder->send($request, [], 204);
    }
}
