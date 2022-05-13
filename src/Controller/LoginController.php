<?php

namespace App\Controller;

use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class LoginController
{
    /**
     * @Route("/login", methods={"POST"}, name="login")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Return Bearer Token",
     *
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Error : Invalid credentials."
     * )
     * @SWG\Parameter(
     *     name="Client",
     *     in="body",
     *     description="Product pagination",
     *     @SWG\Schema(
     *         @SWG\Property(property="email", type="string", example="email"),
     *         @SWG\Property(property="username", type="string", example="username"),
     *         @SWG\Property(property="password", type="string", example="password")
     *     )
     * )
     * @SWG\Tag(name="Login")
     */
    public function index()
    {
    }
}
