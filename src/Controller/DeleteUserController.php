<?php

namespace App\Controller;

use App\Exceptions\ApiException;
use App\Repository\UserRepository;
use App\Responder\JsonResponder;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DeleteUserController
{
    private $manager;
    private $security;
    private $userRepository;
    private $userVoter;
    private $responder;

    public function __construct(
        EntityManagerInterface $manager,
        Security $security,
        UserRepository $userRepository,
        UserVoter $userVoter,
        JsonResponder $responder
    ) {
        $this->manager = $manager;
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->userVoter = $userVoter;
        $this->responder = $responder;
    }

    /**
     * @Route("/user/{id}", methods={"DELETE"}, name="deletelUser")
     * @SWG\Response(
     *     response=204,
     *     description="Return empty body",
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
     *     description="The id of the user"
     * )
     * @SWG\Tag(name="User")
     * @SecurityDoc(name="Bearer")
     */
    public function deleteUser($id, Request $request)
    {
        $user = $this->userRepository->findOneById($id);

        if (null == $user) {
            throw new ApiException('This user not exist.', 404);
        }


        $this->manager->remove($user);
        $this->manager->flush();

        return $this->responder->send($request, [], 204);
    }
}
