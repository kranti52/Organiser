<?php
namespace App\Usecase;


use Silex\Application;
use App\Usecase\UserUsecase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class SocialLoginUsecase {
    private $app;
    public function __construct($app) {
        $this->app=$app;
    }
    
    public function Login($data) {
        
        if($data['service']=='Facebook') {
                $check_id=$data['id'].'f';
        }
        elseif($data['service']=='Google') {
                 $check_id=$data['id'].'g';
        }
        $user_value= $this->app['usecase.user']->getUserByLoginId($check_id);
        
        if(!$user_value) {
                
        
            if($data['service']=='Facebook') {
               
               $email=$this->app['security']->getToken()->getUser()->getEmail();
               $name=$this->app['security']->getToken()->getUser()->getUsername();
               $uid=$this->app['security']->getToken()->getUid().'f';
               $username=$uid;
               $user_info=array('email'=>$email, 'name'=>$name,'login_id'=>$uid,'username'=>$username);
               $result=$this->app['usecase.user']->createUser($user_info);
              
               $this->app['session']->set('username', $username);
               $this->app['session']->set('id', $uid);
               $response = new Response();
               $cookie = new Cookie('Organiser', $uid, time()+(3600*24*30));
               $response->headers->setCookie($cookie);
               $response->send();
                return $result;
                   
            }
            elseif($data['service']=='Google') {
               $email=$this->app['security']->getToken()->getUser()->getEmail();
               $name=$this->app['security']->getToken()->getUser()->getUsername();
               $uid=$this->app['security']->getToken()->getUid().'g';
               $username=$uid;
               $user_info=array('email'=>$email, 'name'=>$name,'login_id'=>$uid,'username'=>$username);
               $result=$this->app['usecase.user']->createUser($user_info);
               
               $this->app['session']->set('username', $username);
               $this->app['session']->set('id', $uid);
               $response = new Response();
               $cookie = new Cookie('Organiser', $uid, time()+(3600*24*30));
               $response->headers->setCookie($cookie);
               $response->send();
               
                return $result;
            }
        }
        else {
                
          
            $response = new Response();
            $cookie = new Cookie('Organiser', $check_id, time()+(3600*24*30));
            $response->headers->setCookie($cookie);
            $response->send();
            
            $user_data=$this->app['usecase.user']->getUserByLoginId($check_id);
            $result=$user_data->getUsername();
            $this->app['session']->set('username', $result);
            $this->app['session']->set('id', $check_id);
            return $result;
        }
    }
    
    public function Logout() {
        $this->app['session']->inValidate();
        $this->app['session']->clear();
        $response=new Response();
        $cookie = new Cookie('Organiser', 'Kranti' ,time()-(3600*24*30));
        $response->headers->setCookie($cookie);
        $response->headers->clearCookie('Organiser');
        $response->headers->clearCookie('PHPSESSID');
        $response->send();
        
    }
}