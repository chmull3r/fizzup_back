<?php

namespace App\Controller;

use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;

class CommentController extends AbstractController
{
    #[Route('/comment/new', name: 'app_add_comment', methods:'POST')]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $comment = new Comment();
        $comment->setDate(new \DateTime());
        // check if data respect formType rules
        $form = $this->createForm(CommentType::class, $comment, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($comment);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            //return new RedirectResponse('/comments');
            return new JsonResponse(
                ['result' => $comment->getId()]
            );
        }
        return new JsonResponse(
            ['result' => []]
        );
    }

    #[Route('/comments', name: 'app_comments_list')]
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = [
            'image' => '/images/magic-photo.png',
            'question' => 'un corgi peut-il marcher 30km dans les Vosges en une seule et même journée ?',
            'author' => 'moi',
            'content' => "ouiuouiouiuouiuouiuouiuouiu"
        ];

        $commentsList = $entityManager->getRepository(Comment::class)->findBy([], ['date' => 'DESC']);
        // Opinion examples
//        $commentsList = [
//            0 => [
//                'pseudo' => 'troisticha',
//                'email' => 'troisticha@miaou.fr',
//                'note' => '3',
//                'text' => 'lulululululululululul',
//                'image' => "/images/tisha.png",
//                'date' => '15.04.2023',
//            ],
//            1 => [
//                'pseudo' => 'ticha',
//                'email' => 'ticha@miaou.fr',
//                'note' => '5',
//                'text' => 'miaoumiaoumioaumiaou',
//                'image' => "/images/tisha.png",
//                'date' => "23.01.2023"
//            ]
//        ];

        return $this->render('comment/index.html.twig', [
            'article' => $article,
            'comments' => $commentsList,
        ]);
    }

}
