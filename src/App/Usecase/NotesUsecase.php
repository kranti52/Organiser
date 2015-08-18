<?php

namespace App\Usecase;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\DBAL\Connection;
use App\Entity\UserEntity;
use PHPMentors\DomainKata\Entity\EntityInterface;
use App\Repository\NotesRepository;

class NotesUsecase {
    private $repository;
    public function __construct(NotesRepository $repository) {
        $this->repository=$repository;   
    }
    public function createNewNotes(array $request) {
        $entity = $this->repository->buildNotesEntity($request);
        $this->repository->save($entity);
        return $entity;
    }
    public function getNotesByUserIdStatus($id,$status)
    {
        $entities = $this->repository->findByUserIdStatus($id,$status);
        if($entities===null){
            return null;
        }
        $note = array();
        foreach ($entities as $id => $entity) {
             $notes = array(
                'notes_id' => $entity->getNotesId(),
                'user_id' => $entity->getUserId(),
                'user_username' => $entity->getUserName(),
                'status' => $entity->getStatus(),
                'title' => $entity->getTitle(),
                'content' => $entity->getContent(),
                'created_at' => $entity->getCreatedAt(),
                'updated_at' => $entity->getUpdatedAt(),
                
            );
            array_push($note, $notes);
        }
        return $note;
    }
    
    public function getNotesByUserIdStatusTitle($id,$status,$title)
    {
        $entity = $this->repository->findByUserIdStatusTitle($id,$status,$title);
        if($entity===null){
            return null;
        }
        $note = array();
        
             $notes = array(
                'notes_id' => $entity->getNotesId(),
                'user_id' => $entity->getUserId(),
                'user_username' => $entity->getUserName(),
                'status' => $entity->getStatus(),
                'title' => $entity->getTitle(),
                'content' => $entity->getContent(),
                'created_at' => $entity->getCreatedAt(),
                'updated_at' => $entity->getUpdatedAt(),
                
            );
            array_push($note, $notes);
       
        return $notes;
    }
    
    public function updateNotesStatus($notes_id,$status){
        $entity = $this->repository->getNotesByNotesId($notes_id);
        $entity->setStatus($status);
        $this->repository->save($entity);
        
        $username=$entity->getUserName();
        $title=$entity->getTitle();
        $data=array('username'=>$username,'title'=>$title);
        return $data;
    }
    
    public function deleteNotes($notes_id) {
        $entity = $this->repository->getNotesByNotesId($notes_id);
        $this->repository->deleteNotesByNotesId($notes_id);
        $username=$entity->getUserName();
        $title=$entity->getTitle();
        $data=array('username'=>$username,'title'=>$title);
        return $data;
        
    }
}
