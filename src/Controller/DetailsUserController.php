<?php

namespace App\Controller;

use App\Exceptions\ApiException;
use App\Links\LinksUserDTOGenerator;
use App\Repository\UserRepository;
use App\Responder\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetailsUserController
{
    private $userRepository;
    private $responder;

    public function __construct(
        UserRepository $userRepository,
        JsonResponder $responder,
        LinksUserDTOGenerator $links
    ) {
        $this->userRepository = $userRepository;
        $this->responder = $responder;
        $this->links = $links;
    }

    /**
     * @Route("/user/{id}", methods={"GET"}, name="detailsUser")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one user",
     *
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Error : This user not exist.",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the user"
     * )
     * @SWG\Tag(name="User")
     * @SecurityDoc(name="Bearer")
     */
    public function detailsUser($id, Request $request)
    {
        $user = $this->userRepository->findOneById($id);
        if (null == $user) {
            throw new ApiException('This user not exist.', 404);
        }

        $this->links->addLinks($user);

        return $this->responder->send($request, $user);
    }
}
