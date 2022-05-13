<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Entity\Product;
use App\Links\LinksUserDTOGenerator;
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


class AddUSerController
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
        UserPasswordEncoderInterface $encoder,
        ValidatorInterface $validator,
        ErrorsValidator $errorsValidator,
        JsonResponder $responder,
        LinksUserDTOGenerator $links
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
     * @Route("/user", methods={"POST"}, name="addUser")
     * * @SWG\Response(
     *     response=201,
     *     description="Returns the created user",
     * )
     * @SWG\Response(
     *     response=409,
     *     description="Invalid : Return all fields with an error",
     * )
     * @SWG\Parameter(
     *     name="User",
     *     in="body",
     *     description="The user you want add",
     *     @SWG\Schema(
     *         @SWG\Property(property="email", type="string", example="celestin.bosongo@yahoo.fr"),
     *         @SWG\Property(property="password", type="string", example="bosongo211"),
     *         @SWG\Property(property="username", type="string", example="username"),
     *         @SWG\Property(property="roles", type="json", example="ROLE_USER")
     *     )
     * )
     * @SWG\Tag(name="User")
     * @SecurityDoc(name="Bearer")
     */

    public function addUser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return $this->responder->send($request, $this->errorsValidator->arrayFormatted($errors), 409);
        }
        $plainPassword = $user->getPassword();
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);

        $this->manager->persist($user);
        $this->manager->flush();

        $userDTO = new UserDTO($user);
        $this->links->addLinks($userDTO);


        return $this->responder->send($request, $userDTO, 201);
    }

  }
