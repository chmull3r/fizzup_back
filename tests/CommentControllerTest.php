<?php

namespace App\Tests;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testPostComment(): void
    {
        $expected = [
            "pseudo" => "rrrrr",
            "email" => "troisticha@miaou.fr",
            "note" => 3,
            "opinion" => "lulululululululululul",
            "image" => "/path/to/tisha.png"
        ];

        $contentSentFromUser = [
            "pseudo" => "rrrrr",
            "email" => "troisticha@miaou.fr",
            "note" => 3,
            "opinion" => "lulululululululululul",
            "image" => "/path/to/tisha.png"
        ];

        $client = static::createClient();
        $request = $client->request('POST', '/comment/new', $contentSentFromUser);

        // Create a crawler from the mock client and request
        $crawler = $client->request('POST', '/comment/new', [], [], [], json_encode($contentSentFromUser));

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();

        // Get the response content as an array
        $responseContent = json_decode($client->getResponse()->getContent(), true);

        // Assert that the response contains the expected content
        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $responseContent[0]);
        }
    }

//    public function testGetComments(): void
//    {
//        $expected = [
//            'id' => 1,
//            'pseudo' => 'mockPseudo',
//            'email' => 'mockEmail',
//            'note' => 9,
//            'opinion' => "mockOpinion",
//            'date' => "25-04-2023"
//        ];
//
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/comments');
//
//        $this->assertResponseIsSuccessful();
//
//        // Get the response content as an array
//        $responseContent = json_decode($client->getResponse()->getContent(), true);
//
//        if ($this->assertArrayHasKey('comments', $responseContent)) {
//            // Assert that the response contains the expected keys
//            foreach ($expected as $key => $value) {
//                $this->assertArrayHasKey($key, $responseContent['comments']);
//            }
//        }
//    }

    public function testGetArticle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');

        $expected = [
            'image' => '/images/une_image',
            'title' => 'un titre de randonnée',
            'author' => 'un auteur',
            'content' => "foo"
        ];

        $this->assertResponseIsSuccessful();

        // Get the response content as an array
        $responseContent = json_decode($client->getResponse()->getContent(), true);

        if ($this->assertArrayHasKey('article', $responseContent)) {
            // Assert that the response contains the expected keys
            foreach ($expected as $key => $value) {
                $this->assertArrayHasKey($key, $responseContent['article']);
            }
        }
    }
}
