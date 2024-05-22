<?php

namespace App\Controller;

use App\Service\HistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/history')]
class HistoryController extends AbstractController
{
    private HistoryService $historyService;

    public function __construct(HistoryService $historyService){
        $this->historyService = $historyService;
    }

    #[Route('/get_all', name: 'app_get_histories', methods: ['GET'])]
    public function index(): JsonResponse
    {
        // recupérer les historiques via un service
        return $this->json($this->historyService->getAll());
    }

    #[Route('/get_histories_by_id_module', name: 'app_get_histories_by_id_module', methods: ['GET'])]
    public function getHistoriesByIdModule(Request $request): JsonResponse
    {
        // recupérer les historiques via un service
        return $this->json($this->historyService->getHistoriesModuleById($request));
    }
}
