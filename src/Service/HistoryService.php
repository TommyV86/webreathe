<?php

namespace App\Service;

use App\Entity\History;
use App\Entity\Module;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class HistoryService {

    private EntityManagerInterface $entityManager;
    private EntityRepository $historyRepository;

    private History $history;
    private array $histories;


    public function __construct(
        EntityManagerInterface $entityManager    
    ){
        $this->entityManager = $entityManager;
    }

    public function create(Module $module) : History {

        $this->history = new History();
        return $this->history->setModule($module)
                             ->setDate(new DateTime("now"));
    }

    //méthode retournant soit un tableau d'historiques soit null
    public function getAll() : ?array {

        $this->historyRepository = $this->entityManager->getRepository(History::class);
        $this->histories = $this->historyRepository->findAll();
        return $this->histories;
    }
}