<?php

namespace App\Service;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * TokenService class
 */
class TokenService
{
    /**
     * jwt variable
     *
     * @var [type]
     */

    public function __construct(readonly protected  JWTEncoderInterface $jwt)
    {

    }

    /**
     * Allow to compare customer in Token with customer in url.
     *
     * @param Request $request
     * @return boolean
     */
    public function compareUsernameInTokenWithIdInUrl(Request $request, User $user): bool
    {
        /*Token used in header request*/
        $token = substr($request->headers->get('Authorization'),7);

        /*Username (email in our case) used in the payload of the Token*/
        $username = $this->jwt->decode($token)['username'];

        if($username != $user->getEmail())
        {
            return false;
        }

        return true;
    }
}
