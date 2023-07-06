<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ContentBundle\Controller\Editor;

/**
 * Class EditorController
 * @package ProgramCms\ContentBundle\Controller\Editor
 */
class EditorController extends \ProgramCms\CoreBundle\Controller\Controller
{

    public function execute()
    {
        return $this->render('@ProgramCmsContent/frontend/editor.html.twig', []);
    }
}