<?php
namespace Admin\UserBundle\Utils;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class Login extends Controller
{
    public function redirectLogin(){
        $session = new Session();
        if(!$session->get('login')) return $this->redirectToRoute('login');
    }
}