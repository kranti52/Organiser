<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;

class AddController
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function Organise(Request $request) {
        
        if($this->app['session']->get('id')!=null) {
           $id=$this->app['session']->get('id');
          $todo_data= $this->app['usecase.notes']->getNotesByUserIdStatus($id,'todo');
          $doing_data= $this->app['usecase.notes']->getNotesByUserIdStatus($id,'doing');
          $done_data= $this->app['usecase.notes']->getNotesByUserIdStatus($id,'done');
           return $this->app['twig']->render('main.html',array(
                    'todo'=>$todo_data,
                    'doing'=>$doing_data,
                    'done'=>$done_data,
                    )); 
       }
       else {
             return $this->app->redirect($this->app['url_generator']->generate('login'));
       }
    }
    
    public function AddNotes(Request $request) {
        
        $status=$request->get('notes_status');
        $username=$request->get('user_name');
        $user_id=$request->get('user_id');
        $content= $request->get('content');   
        $title= $request->get('title'); 
        $notes_data= array('status'=>$status,'user_username'=>$username,'user_id'=>$user_id,'content'=>$content,'title'=>$title);
        $this->app['usecase.notes']->createNewNotes($notes_data);
        return $this->app->redirect($this->app['url_generator']->generate('add',array('username'=>$username,'status'=>$status,'title'=>$title)));
    }
    
    public function AddEvent(Request $request) {
        
        $notes_status=$request->get('notes_status');
        $username=$request->get('user_name');
        $user_id=$this->app['session']->get('id');
        $description= $request->get('description');   
        $title= $request->get('note_title'); 
        $event_name=$request->get('event_name'); 
        $event_status=$request->get('event_status'); 


        $event_data= array(
              'title_status'=>$notes_status,
              'username'=>$username,
              'user_id'=>$user_id,
              'description'=>$description,
              'title'=>$title,
              'event_name'=>$event_name,
              'event_status'=>$event_status,
              );
        $this->app['usecase.event']->createNewEvent($event_data);
     
        return $this->app->redirect($this->app['url_generator']->generate('add',array('username'=>$username,'status'=>$notes_status,'title'=>$title)));
        
    }
    
    public function Add(Request $request) {
       // $request=new Request();
        if($this->app['session']->get('username')) {
           $username=$this->app['session']->get('username');
           $status=$request->query->get('status');
           $title=$request->get('title');
           $user_id=$this->app['session']->get('id');
           if(empty($title)) {
                return $this->app['twig']->render('final_form.html',array(
                     'note_status'=>$status,
                     'user_id'=>$user_id,
                     'username'=>$username,
                    ));
          }
          else {
                    $event_data=$this->app['usecase.event']->getEventByUserIdStatus($user_id,$status,$title);
                    $data= $this->app['usecase.notes']->getNotesByUserIdStatusTitle($user_id,$status,$title);
                      return $this->app['twig']->render('final.html',array(
                                'note_type'=>$data,
                                'event'=>$event_data
                                
                          ));
          }
      }
      else {
         return $this->app->redirect($this->app['url_generator']->generate('login'));
      }
    }
}