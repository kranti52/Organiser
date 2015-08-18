<?php

namespace App\Repository;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\DBAL\Connection;
use App\Entity\EventEntity;
use PHPMentors\DomainKata\Entity\EntityInterface;

class EventRepository {
    private $db;
    public function __construct(connection $db) {
        $this->db=$db;   
    }
    public function buildEventEntity(Array $paramaters = array())
    {
        $entity = new EventEntity;
        $entity->setProperties($paramaters);
        return $entity;
    }
    
    
    public function save(EntityInterface $event) {
          $eventData = array(
            'user_id' => $event->getUserId(),
            'username' => $event->getUserName(),
            'title_status' => $event->getTitleStatus(),
            'title' =>  $event->getTitle(),
            'event_name'=>$event->getEventName(),
            'event_status'=>$event->getEventStatus(),
            'description'=> $event->getDescription(),
        );
        if ($event->getId()) {
            $eventData['updated_at'] = date("Y-m-d H:i:s", time());
            $eventData['created_at'] = $event->getCreatedAt();
            $this->db->update('events', $eventData, array('id' => $event->getId()));
        } 
        else {
            $eventData['updated_at'] = date("Y-m-d H:i:s", time());
            $eventData['created_at'] = date("Y-m-d H:i:s", time());
            $this->db->insert('events', $eventData);
            $id = $this->db->lastInsertId();
            $event->setId($id);
        }
        return null;
    }
    
     public function findEventByUserIdStatus($login_id,$status,$title) {
        $event_data = $this->db->fetchAll('SELECT * FROM events WHERE user_id = ? and title_status = ? and title = ?', array($login_id, $status, $title));
        
         $events = array();
        foreach ($event_data as $data) {
            $id = $data['id'];
            $events[$id] = $this->buildEventEntity($data);
        }
        
        return $event_data ? $events : null;
    }
       public function findEventByUsernameStatus($login_name,$status,$title) {
        $event_data = $this->db->fetchAll('SELECT * FROM events WHERE username = ? and title_status = ? and title = ?', array($login_name, $status, $title));
        
         $events = array();
        foreach ($event_data as $data) {
            $id = $data['id'];
            $events[$id] = $this->buildEventEntity($data);
        }
        
        return $event_data ? $events : null;
    }
    
    public function deleteEventByUsernameStatus($username,$status,$title) {
        $this->db->delete('events',array('username'=>$username,'title_status'=>$status,'title'=>$title));
    }
    public function deleteEventById($id) {
        $this->db->delete('events',array('id'=>$id));
    }
    
    public function findEventById($id) {
        $event_data=$this->db->fetchAssoc('SELECT * FROM events WHERE id=?', array($id));
        return $event_data?$this->buildEventEntity($event_data):null;
    }
}
