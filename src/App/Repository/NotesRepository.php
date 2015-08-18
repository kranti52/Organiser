<?php

namespace App\Repository;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\DBAL\Connection;
use App\Entity\NotesEntity;
use PHPMentors\DomainKata\Entity\EntityInterface;

class NotesRepository {
    private $db;
    public function __construct(connection $db) {
        $this->db=$db;   
    }
    public function buildNotesEntity(Array $paramaters = array())
    {
        $entity = new NotesEntity;
        $entity->setProperties($paramaters);
        return $entity;
    }
    
    public function findByTitleStatus($title,$status,$username) {
        $data = $this->db->fetchAll('SELECT * FROM sticky_notes WHERE title = ? and status=? and user_username=?', array($title,$status,$username));
        return $data ? $this->buildNotesEntity($data) : null;
    }
    
    public function save(EntityInterface $notes) {
          $notesData = array(
            'user_id' => $notes->getUserId(),
            'user_username' => $notes->getUserName(),
            'status' => $notes->getStatus(),
            'title' =>  $notes->getTitle(),
            'content'=> $notes->getContent(),
        );
        if ($notes->getNotesId()) {
            $notesData['updated_at'] = date("Y-m-d H:i:s", time());
            $notesData['created_at'] = $notes->getCreatedAt();
            $this->db->update('sticky_notes', $notesData, array('notes_id' => $notes->getNotesId()));
        } 
        else {
            $notesData['updated_at'] = date("Y-m-d H:i:s", time());
            $notesData['created_at'] = date("Y-m-d H:i:s", time());
            $this->db->insert('sticky_notes', $notesData);
            $id = $this->db->lastInsertId();
            $notes->setNotesId($id);
        }
        return null;
    }
    
     public function findByUserIdStatus($login_id,$status) {
        $notes_data = $this->db->fetchAll('SELECT * FROM sticky_notes WHERE user_id = ? and status=?', array($login_id, $status));
        
         $notes = array();
        foreach ($notes_data as $data) {
            $id = $data['notes_id'];
            $notes[$id] = $this->buildNotesEntity($data);
        }
        
        return $notes_data ? $notes : null;
    }
    
     public function findByUserIdStatusTitle($login_id,$status,$title) {
        $notes_data = $this->db->fetchAssoc('SELECT * FROM sticky_notes WHERE user_id = ? and status=? and title=?', array($login_id, $status,$title));
        return $notes_data ? $this->buildNotesEntity($notes_data) : null;
    }
    
     public function getNotesByNotesId($notes_id) {
        $notes_data = $this->db->fetchAssoc('SELECT * FROM sticky_notes WHERE notes_id = ?', array($notes_id));
        return $notes_data ? $this->buildNotesEntity($notes_data) : null;
    }
    
    public function deleteNotesByNotesId($notes_id) {
        $this->db->delete('sticky_notes', array('notes_id'=>$notes_id));
    }
}
