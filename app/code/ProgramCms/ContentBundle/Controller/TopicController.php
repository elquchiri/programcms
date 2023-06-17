<?php


namespace ProgramCms\ContentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{

    #[Route('/content/topic/id/{id}', name: 'content_topic')]
    public function contentTopicView(

    ): Response
    {
        return $this->render('@ElectroForumsContent/frontend/content/topic.html.twig', [

        ]);
    }
}