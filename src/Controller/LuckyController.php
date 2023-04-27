<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


#[Route('/lucky/number')]
class LuckyController
{
    public function number(Request $request): JsonResponse
    {
        return new JsonResponse(
            ['result' => "coucou"]
        );
    }
}
