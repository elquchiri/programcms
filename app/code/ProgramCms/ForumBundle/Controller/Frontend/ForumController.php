<?php


namespace ProgramCms\ForumBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    #[Route('/forum/id/{id}', name: 'electro_forums_forum_view')]
    public function forumView(

    ): Response
    {
        return $this->render('@ElectroForumsForum/frontend/forum.html.twig', [

        ]);
    }
}