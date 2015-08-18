<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;

class UpdateController
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function UpdateNote(Request $request) {
       
        $notes_id=$request->get('notes_id');
        $changed_status=$request->get('changed_status');
        $current_status=$request->get('current_status');
        if($changed_status=='done') {
             $data=$this->app['usecase.notes']->updateNotesStatus($notes_id,$changed_status);
             $title=$data['title'];
            $username=$data['username'];
         
            $entities= $this->app['usecase.event']->updateEventStatusByTitle($username,$title,$current_status,$changed_status,'1');
        
        }
        elseif($changed_status=='delete'){
             $data= $this->app['usecase.notes']->deleteNotes($notes_id);
            $username=$data['username'];
            $title=$data['title'];
            $this->app['usecase.event']->deleteEventByTitle($username,$title,$current_status);
        }
        else {
            $entity=$this->app['usecase.notes']->updateNotesStatus($notes_id,$changed_status);
            $username=$entity['username'];
            $title=$entity['title'];
            $entities= $this->app['usecase.event']->updateEventStatusByTitle($username,$title,$current_status,$changed_status,'0');
        }
      
     
        return $this->app->redirect($this->app['url_generator']->generate('organise',array('username'=>$username)));
            
    }
    
    public function UpdateEvent(Request $request) {
        
        $event_id=$request->get('event_id');
        $changed_status=$request->get('changed_event_status');
        if($changed_status=='delete') {
           $data=$this->app['usecase.event']->deleteEventByEventId($event_id);
           $username=$data['username'];
           $title=$data['title'];
           $notes_status=$data['status'];
        }
        else {
            $data=$this->app['usecase.event']->updateEventStatusById($event_id,$changed_status);
           $username=$data['username'];
           $title=$data['title'];
           $notes_status=$data['status'];
        }
        return $this->app->redirect($this->app['url_generator']->generate('add',array('username'=>$username,'status'=>$notes_status,'title'=>$title)));
        
    }
}