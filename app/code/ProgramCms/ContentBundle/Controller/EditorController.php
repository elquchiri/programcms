<?php


namespace ProgramCms\ContentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorController extends AbstractController
{

    #[Route('/content/editor', name: 'frontend_editor')]
    public function frontEditor(

    ): Response
    {
        return $this->render('@ProgramCmsContent/frontend/editor.html.twig', [

        ]);
    }
}