<?php

namespace App\Service;

use App\Entity\History;
use App\Entity\Module;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

class HistoryService {

    private EntityManagerInterface $entityManager;
    private EntityRepository $historyRepository;

    private History $history;
    private array $histories;
    private array $historiesModule;
    private array $attribute_from_data;
    private int $idModule;


    public function __construct(
        EntityManagerInterface $entityManager    
    ){
        $this->entityManager = $entityManager;
    }

    public function create(Module $module) : History {

        $this->history = new History();
        return $this->history->setModule($module)
                             ->setTemperatureModule($module->getTemperature())
                             ->setSpeedModule($module->getSpeed())
                             ->setDate(new DateTime("now"));
    }

    //méthode retournant soit un tableau d'historiques soit null
    public function getAll() : ?array {

        $this->historyRepository = $this->entityManager->getRepository(History::class);
        $this->histories = $this->historyRepository->findLastFive();
        return $this->histories;
    }

    //méthode retournant un tableau concernant un historique d'un module ou null
    public function getHistoriesModuleById(Request $request) : ?array {

        $this->idModule = $request->query->getInt('moduleId');

        $this->historyRepository = $this->entityManager->getRepository(History::class);
        $this->historiesModule = $this->historyRepository->findHistoriesModuleById($this->idModule);

        return $this->historiesModule;       
    }
}