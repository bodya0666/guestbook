<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Posts;
use Knp\Component\Pager\Paginator;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="main")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $request->setLocale('ru_RU');
        $order = $request->query->get('order');
        $column = $request->query->get('column');
        if (!$column || !$order) {
            $column = 'date';
            $order = 'DESC';
        }
        $username = '?column=username&order=asc';
        $email = '?column=email&order=asc';
        $date = '?column=date&order=asc';
        if ($column == 'username' && $order == 'asc') {
            $username = '?column=username&order=desc';
        }
        if ($column == 'email' && $order == 'asc') {
            $email = '?column=email&order=desc';
        }
        if ($column == 'date' && $order == 'asc') {
            $date = '?column=date&order=desc';
        }
        $repository = $this->getDoctrine()->getRepository(Posts::class);
        $allPostsQuery = $repository->findBy(
            ['status' => true],
            [$column => $order]
        );

        $posts = $paginator->paginate(
            $allPostsQuery,
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('index.html.twig', [
            'posts' => $posts,
            'username' => $username,
            'email' => $email,
            'date' => $date,
            ]);
    }


    /**
     * @route("/changeLocale", name="changeLocale")
     */
    public function changeLocale(Request $request, SessionInterface $session)
    {

        $form = $this->createFormBuilder(null)
            ->add('locale', ChoiceType::class, [
                'choices' => [
                    'Русский' 	=> 'ru_RU',
                    'English'	=> 'en',
                ],
                'placeholder' => 'Language',
                'label' => false,
            ])
            ->add('save', SubmitType::class)
            ->getForm()
        ;


        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            setcookie('lang', $form->getData()['locale'], strtotime('now + 1 year'));
            header("Refresh:0");
        }
        return $this->render('locale.html.twig', [
            'form'		=> $form->createView(),

        ]);
    }

}
