<?php

namespace App\Controller;

use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;

class CommentController extends AbstractController
{
    #[Route('/comment/new', name: 'app_add_comment', methods:['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $comment = new Comment();
        $comment->setDate(new \DateTime());
        // check if data respect formType rules
        $form = $this->createForm(CommentType::class, $comment, [
            'method' => 'post'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // If the form was submitted and is valid, update the comment object
            $comment = $form->getData();

            // Upload the image file, if present
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                // Use the Symfony Filesystem component to move the file to public/images directory
                $filename = $this->generateUniqueFileName().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('/public/images/'),
                    $filename
                );
                $comment->setImage($filename);
            }

            // Save the comment to the database
            $entityManager->persist($comment);
            $entityManager->flush();

            return new JsonResponse(
                ['result' => $comment->getId()]
            );
        }

        // If the form was not submitted or is not valid, return a JSON response with the form errors
        $errors = $this->getFormErrors($form);
        return new JsonResponse(['errors' => $errors]);
    }

    #[Route('/comments', name: 'app_comments_list')]
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = [
            'image' => '/images/corgi_in_mountain.jpg',
            'question' => 'un corgi peut-il marcher 30km dans les Vosges en une seule et même journée ?',
            'author' => 'HappyRando',
            'content' => "Ut et accumsan turpis. Aenean fermentum urna in neque convallis mollis. Sed a dictum eros. Sed ex leo, pellentesque at dictum id, gravida ac mauris. Praesent nec pellentesque odio. Duis pharetra, justo ac mattis dignissim, lorem ipsum iaculis odio, quis commodo tellus felis eget eros. Sed iaculis mi ut felis bibendum molestie. In id hendrerit ex. Phasellus gravida porta tortor tempor accumsan. Maecenas tempus enim a congue aliquam."
        ];

        $commentsList = $entityManager->getRepository(Comment::class)->findBy([], ['date' => 'DESC']);

        return $this->render('comment/listAndFormPage.twig', [
            'article' => $article,
            'comments' => $commentsList,
        ]);
    }

    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];

        // Loop through all form fields and get their errors
        foreach ($form->all() as $commentFieldForm) {
            $fieldErrors = $commentFieldForm->getErrors();
            if (count($fieldErrors) > 0) {
                $errors[$commentFieldForm->getName()] = (string) $fieldErrors;
            }
        }

        return $errors;
    }
}
