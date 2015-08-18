<?php
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;


include("keys.php");
$app=new Application();

$app->register(new UrlGeneratorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    return $twig;
}));
    $app->register(new Gigablah\Silex\OAuth\OAuthServiceProvider(), array(
        'oauth.services' => array(
            'Facebook' => array(
                'key' => FACEBOOK_API_KEY,
                'secret' => FACEBOOK_API_SECRET,
                'scope' => array('email'),
                'user_endpoint' => 'https://graph.facebook.com/me?fields=id,name,email'
            ),
             'Google' => array(
                'key' => GOOGLE_API_KEY,
                'secret' => GOOGLE_API_SECRET,
                'scope' => array(
                    'https://www.googleapis.com/auth/userinfo.email',
                    'https://www.googleapis.com/auth/userinfo.profile'
                ),
                'user_endpoint' => 'https://www.googleapis.com/oauth2/v1/userinfo'
            )
        )
    ));

// Provides session storage
$app->register(new Silex\Provider\SessionServiceProvider(), array(
    'session.storage.save_path' => '/tmp'
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'default' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'oauth' => array(
            
                'failure_path' => '/',
                
            ),
            'logout' => array(
                'logout_path' => '/logout',
                'target_url' => 'signout',
                
            ),
            
            'users' => new Gigablah\Silex\OAuth\Security\User\Provider\OAuthInMemoryUserProvider()
        )
    ),
    'security.access_rules' => array(
        array('^/auth', 'ROLE_USER')
    )
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), (new App\Config\DatabaseSettings())->getOptions());

$app['repository.user'] = $app->share(function ($app) {
    return new App\Repository\UserRepository($app['db']);
});
$app['usecase.user']=$app->share(function ($app) {
    return new App\Usecase\UserUsecase($app['repository.user']);
});
$app['repository.notes'] = $app->share(function ($app) {
    return new App\Repository\NotesRepository($app['db']);
});
$app['usecase.notes']=$app->share(function ($app) {
    return new App\Usecase\NotesUsecase($app['repository.notes']);
});

$app['repository.event'] = $app->share(function ($app) {
    return new App\Repository\EventRepository($app['db']);
});
$app['usecase.event']=$app->share(function ($app) {
    return new App\Usecase\EventUsecase($app['repository.event']);
});
$app['usecase.social_login']=$app->share(function ($app) {
    return new App\Usecase\SocialLoginUsecase($app);
});

$app['controller.add']=$app->share(function ($app) {
    return new App\Controller\AddController($app);
});

$app['controller.login']=$app->share(function ($app) {
    return new App\Controller\LoginController($app);
});

$app['controller.update']=$app->share(function ($app) {
    return new App\Controller\UpdateController($app);
});
return $app;