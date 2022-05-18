<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Exceptions\ApiException;
use App\Links\LinksUserDTOGenerator;
use App\Paging\UserPaging;
use App\Responder\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListOfUserController
{
    private $responder;
    private $paging;
    private $userDTO;
    private $links;

    public function __construct(
        JsonResponder $responder,
        UserPaging $paging,
        UserDTO $userDTO,
        LinksUserDTOGenerator $links
    ) {
        $this->responder = $responder;
        $this->paging = $paging;
        $this->userDTO = $userDTO;
        $this->links = $links;
    }

    /**
     * @Route("/user", methods={"GET"}, name="listOfUser")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return list of people",
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
     *     description="User pagination"
     * )
     * @SWG\Tag(name="User")
     * @SecurityDoc(name="Bearer")
     */
    public function listOfuser(Request $request)
    {

        $user = $this->paging->getDatas($request->query->get('page'));
        
        
        if ($user!= "ROLE_ADMIN") {
            throw new ApiException('You are not admin,  access denied  🙅 ', 403);
        }

        $userDTO = $this->userDTO->getUserDTO($user);

        $this->links->addLinks($userDTO);

        return $this->responder->send($request, $userDTO);
    }
}
