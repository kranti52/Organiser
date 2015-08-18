<?php
namespace App\Usecase;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use App\Repository\EventRepository;

class EventUsecase {
    private $repository;
    
    public function __construct(EventRepository $repository) {
        $this->repository=$repository;
    }
    
    public function createNewEvent(array $request) {
        $entity = $this->repository->buildEventEntity($request);
        $this->repository->save($entity);
        return $entity;
    }
    public function getEventByUserIdStatus($id,$status,$title)
    {
        $entities = $this->repository->findEventByUserIdStatus($id,$status,$title);
        if($entities===null){
            return null;
        }
        $event = array();
        foreach ($entities as $id => $entity) {
             $events = array(
                'id' => $entity->getId(),
                'user_id' => $entity->getUserId(),
                'username' => $entity->getUserName(),
                'title_status' => $entity->getTitleStatus(),
                'title' => $entity->getTitle(),
                'description' => $entity->getDescription(),
                'event_name' => $entity->getEventName(),
                'event_status' => $entity->getEventStatus(),
                'created_at' => $entity->getCreatedAt(),
                'updated_at' => $entity->getUpdatedAt(),
                
            );
            
            array_push($event, $events);
        }
        return $event;
    }
   
     public function updateEventStatusByTitle($username,$title,$status,$changed_status,$flag){
        $entities = $this->repository->findEventByUsernameStatus($username,$status,$title);
        if($entities===null){
            return null;
        }
        $event = array();
        foreach ($entities as $id => $entity) {
        $entity->setTitleStatus($changed_status);  
        if($flag=='1'){
            $entity->setEventStatus($changed_status);
        }
        
        $this->repository->save($entity);
            
           
        }
        return $entities;
    }
    
    
    public function deleteEventByTitle($username,$title,$status) {
        $this->repository->deleteEventByUsernameStatus($username,$status,$title);
    }
    public function deleteEventByEventId($id) {
        $entity=$this->repository->findEventById($id);
        $this->repository->deleteEventById($id);
        $username=$entity->getUserName();
        $title=$entity->getTitle();
        $status=$entity->getTitleStatus();
        $data=array('username'=>$username,'title'=>$title,'status'=>$status);
        return $data;

    }
    
      public function updateEventStatusById($id,$changed_status) {
        $entity=$this->repository->findEventById($id);
        $entity->setEventStatus($changed_status);
        $this->repository->save($entity);
        
        $username=$entity->getUserName();
        $title=$entity->getTitle();
        $status=$entity->getTitleStatus();
        $data=array('username'=>$username,'title'=>$title,'status'=>$status);
        return $data;

    }
}
