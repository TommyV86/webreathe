<?php

namespace App\Service;

use App\Entity\Module;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ModuleService {

    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;
    private EntityRepository $moduleRepository;

    private mixed $data;
    private Module $module;
    private array $modules;

    private string $name;
    private string $description;
    private string $state;
    private float $speed;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager    
    ){
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    public function save(Request $request) : bool {

        $this->data = $request->getContent();
        if ($this->data == null) return false;

        $this->module = $this->serializer->deserialize($this->data, Module::class, "json");

        $this->entityManager->persist($this->module);
        $this->entityManager->flush();

        return true;
    }

    public function getAll() : array | null {

        $this->moduleRepository = $this->entityManager->getRepository(Module::class);

        $this->modules = $this->moduleRepository->findAll();

        if(count($this->modules) > 0){
            foreach ($this->modules as $module) {
                
                $module->setSpeed(rand(0, 100));
                $this->speed = $module->getSpeed();
                if($this->speed > 40) {
                    $module->setTemperature(rand(60, 120));
                } else if($this->speed < 20) {
                    $module->setTemperature(rand(0, 20));
                } else {
                    $module->setTemperature(rand(20, 50));
                };

                $this->state = $module->getTemperature() < 100 ? 'En marche' : 'En panne';
                $module->setState($this->state);
                $module->setDate(new DateTime("now"));

                $this->entityManager->persist($module);
                $this->entityManager->flush();
            }
        }
        

        return $this->modules;
    }
}