<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function Login(Request $request) {
        $token=$this->app['security']->getToken();
        if(($token)&& ($this->app['session']->isStarted()) && !$this->app['security.trust_resolver']->isAnonymous($token)) {
                return $this->app->redirect($this->app["url_generator"]->generate("social_login_check"));
        }
        else {
            
            return $this->app['twig']->render('index.html',array(
                    'login_paths' => $this->app['oauth.login_paths'],
                    'error' => $this->app['security.last_error']($request)
                ));
                    
        }
    }
    
    public function SocialLogin(Request $request) {
        $service=$this->app['security']->getToken()->getService();
        $id=$this->app['security']->getToken()->getUid();
        
        $send_data=array('service'=>$service,'id'=>$id);
        $result=$this->app['usecase.social_login']->Login($send_data);
    
        return $this->app->redirect($this->app['url_generator']->generate('organise',array('username'=>$result)));
    }
    
    public function Logout(Request $request) {
        $this->app['usecase.social_login']->Logout();
        return $this->app->redirect($this->app['url_generator']->generate('login'));
    }
}