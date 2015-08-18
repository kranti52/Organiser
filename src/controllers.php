<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;

$app->match('/',"controller.login:Login") 
->bind('login')
->method('GET|POST');

$app->match('/social_login/',"controller.login:SocialLogin")
->bind('social_login_check')
->method('GET|POST');

$app->match('/{username}/organise',"controller.add:Organise")
->bind('organise')
->method('GET|POST');

$app->match('/signout/',"controller.login:Logout")
->bind('signout')
->method('GET|POST');

$app->get('/{username}/organise/add',"controller.add:Add")
->bind('add');

$app->get('/{user_name}/organise/addNewList',"controller.add:AddNotes")
->bind('add_list');

$app->get('/{user_name}/organise/addNewEvent',"controller.add:AddEvent")
->bind('add_event');

$app->get('/{user_name}/organise/update_note',"controller.update:UpdateNote")
->bind('update_note');

$app->get('/{user_name}/organise/update_event',"controller.update:UpdateEvent")
->bind('update_event');