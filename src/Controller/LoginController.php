<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class LoginController
{
    /**
     * @Route("/login", methods={"POST"}, name="login")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retourne un Token Bearer",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="token", type="string", description="Le token Bearer retourné pour l'authentification")
     *     )
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Erreur : Identifiants invalides."
     * )
     * @SWG\Parameter(
     *     name="Client",
     *     in="body",
     *     description="Informations de connexion du client",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="email", type="string", example="user@example.com"),
     *         @SWG\Property(property="username", type="string", example="user123"),
     *         @SWG\Property(property="password", type="string", example="password123")
     *     )
     * )
     * @SWG\Tag(name="Login")
     */
    public function index(Request $request)
    {
        // Récupération des données envoyées dans le corps de la requête
        $data = json_decode($request->getContent(), true);

        // Exemple de validation des informations de connexion
        if (isset($data['username']) && isset($data['password'])) {
            // Ici vous pouvez valider les identifiants avec votre logique de connexion
            if ($data['username'] === 'user123' && $data['password'] === 'password123') {
                // Connexion réussie, retourner un token fictif (par exemple)
                return new JsonResponse(['token' => 'Bearer example_token'], 200);
            }
        }

        // Si les informations sont incorrectes, retournez une erreur 401
        return new JsonResponse(['error' => 'Invalid credentials'], 401);
    }
}
