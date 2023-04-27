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
    #[Route('/', name: 'app_homepage')]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $file = "https://img.freepik.com/vecteurs-libre/caricature-chien-beagle-fond-blanc_1308-68249.jpg?w=2000";
        $comment = new Comment();
        $comment->setPseudo('Keyboard');
        $comment->setEmail('coucou@coucou.fr');
        $comment->setNote(5);
        $comment->setText('Ergonomic and stylish!');
        $comment->setImage($file);

        // check if data respect formType rules
        $form = $this->createForm(CommentType::class, $comment);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form['image']->getData());
        }
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        // $entityManager->persist($comment);

        // actually executes the queries (i.e. the INSERT query)
        // $entityManager->flush();

        return new JsonResponse(
           ['form' => $form]
            //['result' => $comment->getId()]
        );
    }

    #[Route('/comments', name: 'app_comments_list')]
    public function list(): Response
    {
        $article = [
            'image' => '/images/magic-photo.png',
            'question' => 'un corgi peut-il marcher 30km dans les Vosges en une seule et même journée ?',
            'author' => 'moi',
            'content' => "ouiuouiouiuouiuouiuouiuouiu"
        ];

        $commentsList = [
            0 => [
                'pseudo' => 'troisticha',
                'email' => 'troisticha@miaou.fr',
                'note' => '3',
                'text' => 'lulululululululululul',
                'image' => "/images/tisha.png",
            ],
            1 => [
                'pseudo' => 'ticha',
                'email' => 'ticha@miaou.fr',
                'note' => '5',
                'text' => 'miaoumiaoumioaumiaou',
                'image' => "/images/tisha.png",
            ]
        ];

        return $this->render('comment/index.html.twig', [
            'article' => $article,
            'comments' => $commentsList,
        ]);
    }
}
