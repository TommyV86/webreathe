<?php

namespace App\Controller;

use App\Service\HistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}
