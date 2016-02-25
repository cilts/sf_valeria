<?php

namespace Admin\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Admin\UserBundle\Entity\user;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{

    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function indexAction()
    {
        $session = new Session();
        if(!$session->get('login')) return $this->redirectToRoute('login');

        $users = $this->getDoctrine()->getRepository('AdminUserBundle:user')->findAll();

        return $this->render('AdminUserBundle:Default:index.html.twig', array('users' => $users));
    }

    /**
     * @Route("/admin/cadUser", name="cad_user")
     */

    public function createAction(Request $request)
    {
        $session = new Session();
        if(!$session->get('login')) return $this->redirectToRoute('login');

        $user = new user();
        $user->setNome('Digite um Nome');
        $user->setEmail('Digite um E-mail');
        $user->setSenha('');

        $form = $this->createFormBuilder($user)
            ->add('nome', TextType::class)
            ->add('email', TextType::class)
            ->add('senha', RepeatedType::class, array('type' => PasswordType::class, 'first_options' => array('label' => 'Senha'),
                'second_options' => array('label' => 'Repita Senha'),))
            ->add('save', SubmitType::class, array('label' => 'Criar Usuario', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('AdminUserBundle:Default:cadUser.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/admin/altUser/{id}", name="alter_user")
     */
    public function alterAction(Request $request, $id)
    {
        $session = new Session();
        if(!$session->get('login')) return $this->redirectToRoute('login');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminUserBundle:user')->find($id);
        $user->getNome();
        $user->getEmail();
        $user->getSenha();

        $form = $this->createFormBuilder($user)
            ->add('nome', TextType::class)
            ->add('email', TextType::class)
            ->add('update', SubmitType::class, array('label' => 'Alterar Usuario', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setNome($user->getNome());
            $user->setEmail($user->getEmail());
            $em->flush();
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('AdminUserBundle:Default:altUser.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/admin/altUserPass/{id}", name="alter_user_pass")
     */
    public function alterPassAction(Request $request, $id)
    {
        $session = new Session();
        if(!$session->get('login')) return $this->redirectToRoute('login');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminUserBundle:user')->find($id);
        $user->getSenha();

        $senha = $this->createFormBuilder($user)
            ->add('senha', RepeatedType::class, array('type' => PasswordType::class, 'first_options' => array('label' => 'Senha'),
                'second_options' => array('label' => 'Repita Senha'),))
            ->add('update', SubmitType::class, array('label' => 'Alterar Senha', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        $senha->handleRequest($request);

        if ($senha->isSubmitted() && $senha->isValid()) {
            $user->setSenha($user->getSenha());
            $em->flush();
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('AdminUserBundle:Default:altUserPass.html.twig', array('form' => $senha->createView()));
    }

    /**
     * @Route("/admin/delUser/{id}", name="del_user")
     */
    public function deleteAction(Request $request, $id)
    {
        $session = new Session();
        if(!$session->get('login')) return $this->redirectToRoute('login');

        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository('AdminUserBundle:user')->find($id);
        $em->remove($produto);
        $em->flush();

        return $this->redirectToRoute('admin_user');

    }
}