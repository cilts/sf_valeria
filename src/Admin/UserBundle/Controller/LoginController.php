<?php

namespace Admin\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Admin\UserBundle\Entity\user;

class LoginController extends Controller
{

    public function loginAction()
    {

        $formFactory = Forms::createFormFactory();

        $form = $formFactory->createNamedBuilder('login')
                ->setMethod('POST')
                ->add('email', TextType::class)
                ->add('senha', PasswordType::class)
                ->add('login', SubmitType::class)
                ->getForm();

        $request = Request::createFromGlobals();

        //$form->handleRequest($request);

        if ($form->isSubmitted()) {
            echo $form;
        }

        return $this->render('AdminUserBundle:Login:index.html.twig', array('form'=>$form->createView(),));
    }

    public function verifyAction(Request $request)
    {
        $login = $request->request->all();

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminUserBundle:user')->findOneBy(array('email'=>$login['login']['email']));
        if($user) {
            $email = $user->getEmail();
            $senha = $user->getSenha();

            if ($login['login']['email'] == $email && $login['login']['senha'] == $senha) {
                $session = new Session();
                $session->set('login',array('id'=>$user->getId(),'nome'=>$user->getNome(),'email'=>$user->getEmail()));
                return $this->redirectToRoute('admin_user');
            } else {
                return $this->render('AdminUserBundle:Login:sucesso.html.twig', array('error' => 'Usuário ou senha inválidos!'));
            }
        }else{
            return $this->render('AdminUserBundle:Login:sucesso.html.twig', array('error' => 'Sem Sucesso!'));
        }
    }

    public function deslogarAction(){
        $session = new Session();
        $session->remove('login');
        return $this->redirectToRoute('login');
    }
}
