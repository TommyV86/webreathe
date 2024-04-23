<?php

namespace App\Controller;

use App\Service\ModuleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/module')]
class ModuleController extends AbstractController
{
    private ModuleService $moduleService;
    private bool $isSaved;
    private string $message;

    public function __construct(ModuleService $moduleService){
        $this->moduleService = $moduleService;
    }

    #[Route('/get_all', name: 'app_get_module', methods: ['GET'])]
    public function index(): JsonResponse
    {
        // recupérer les modules via un service
        return $this->json($this->moduleService->getAll());
    }

    #[Route('/save', name: 'app_save_module', methods: ['POST'])]
    public function save(Request $request): JsonResponse
    {
        // save un module via un service
        $this->isSaved = $this->moduleService->save($request);
        $this->message = $this->isSaved ? 'Module registered successfully!' : 'error in the server';
        
        return $this->json(['message' => $this->message]);
    }
}
