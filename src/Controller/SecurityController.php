<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $ip = $this->container->get('request_stack')->getMasterRequest()->getClientIp();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $lastUsername]);
        if ($user) {
            $user->setIp($ip);
            $user->setUserAgent($user_agent);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/reset", name="reset")
     */
    public function reset(\Swift_Mailer $mailer, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $error = null;
        $form = $this->createForm(EmailType::class);
        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $form['email']->getData()]);
        if (!$user) {
            $messages = 'invalid email';
        }
        if ($form->isSubmitted() && $form->isValid() && $user) {
            $password = substr(rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='), 0, 10) ;
            //send message
            $message = (new \Swift_Message())
                ->setSubject('test')
                ->setFrom('symfony@gmail.com')
                ->setTo('maximchuk.bodya@gmail.com')
                ->setBody($password, 'text/html');

            $mailer->send($message);
            $password = $passwordEncoder->encodePassword(
                new User(),
                $password
            );
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }


        return $this->render('security/reset.html.twig', ['form' => $form->createView()]);
    }
}
