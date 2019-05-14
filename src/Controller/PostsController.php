<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\User;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/posts")
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/my", name="posts_index", methods={"GET"})
     */
    public function my_post(UserInterface $id, Request $request, PaginatorInterface $paginator)
    {
        $userId = $id->getId();
        $repository = $this->getDoctrine()->getRepository(Posts::class);
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repositoryUser->findOneBy(['id' => $userId]);
        $post = $repository->findBy(
            ['email' => $user->getEmail()],
            ['date' => 'DESC']
        );

        $posts = $paginator->paginate(
            $post,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/new", name="posts_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $id)
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userId = $id->getId();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy(['id' => $userId]);

            $image = $request->files->get('posts')['image'];
            if ($image) {
                $fileName = md5(uniqid()) . '.' . $image->guessExtension();


                $image->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $post->setImage($fileName);
            }

            $post->setUsername($user->getUsername());
            $post->setEmail($user->getEmail());
            $post->setDate(date('Y-m-d H:i:s'));
            $post->setStatus(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('posts/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posts_show", methods={"GET"})
     */
    public function show(Posts $post): Response
    {
        return $this->render('posts/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="posts_edit")
     */
    public function edit(Request $request, Posts $post, UserInterface $userid)
    {
        $userId = $userid->getId();
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['id' => $userId]);
        if ($user->getEmail() !== $post->getEmail()) {
            return $this->redirectToRoute('main');
        }
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $request->files->get('posts')['image'];
            if ($image) {
                $fileName = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $post->setImage($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('main', [
                'id' => $post->getId(),
            ]);
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posts $post, UserInterface $userid): Response
    {
        $userId = $userid->getId();
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['id' => $userId]);
        if ($user->getEmail() !== $post->getEmail()) {
            return $this->redirectToRoute('main');
        }
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            if ($post->getImage()) {
                unlink($this->getParameter('images_directory') . '/' . $post->getImage());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('main');
    }
}
