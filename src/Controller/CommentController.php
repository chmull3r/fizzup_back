<?php

namespace App\Controller;

use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
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

        dd($form->isSubmitted());
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
}
