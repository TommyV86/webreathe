<?php

namespace App\Service;

use App\Entity\Module;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ModuleService {

    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;
    private EntityRepository $moduleRepository;
    private HistoryService $historyService;

    private mixed $data;
    private Module $module;
    private array $modules;

    private string $state;
    private float $speed;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        HistoryService $historyService    
    ){
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->historyService = $historyService;
    }

    public function save(Request $request) : bool {

        $this->data = $request->getContent();
        if ($this->data == null) return false;

        $this->module = $this->serializer->deserialize($this->data, Module::class, "json");
        $this->module->setDate(new DateTime("now"));
        
        $this->entityManager->persist($this->module);
        $this->entityManager->flush();

        return true;
    }

    //méthode retournant soit un tableau de modules soit null
    public function getAll() : array | null {

        $this->moduleRepository = $this->entityManager->getRepository(Module::class);

        $this->modules = $this->moduleRepository->findAll();

        if(count($this->modules) > 0){
            foreach ($this->modules as $module) {
                //définition de la température en fonction de la vitesse
                $module->setSpeed(rand(0, 100));
                $this->speed = $module->getSpeed();
                if($this->speed > 40) {
                    $module->setTemperature(rand(60, 120));
                } else if($this->speed < 20) {
                    $module->setTemperature(rand(0, 20));
                } else {
                    $module->setTemperature(rand(20, 50));
                };

                //état en panne si la température dépasse 100
                $this->state = $module->getTemperature() < 100 ? 'En marche' : 'En panne';
                $module->setState($this->state);

                //creer une instance d'historique si un module est en panne et la persister
                if($this->state == 'En panne') {
                    $this->entityManager->persist($this->historyService->create($module));
                }
                
                $this->entityManager->persist($module);
                $this->entityManager->flush();
            }
        }
        
        return $this->modules;
    }
}