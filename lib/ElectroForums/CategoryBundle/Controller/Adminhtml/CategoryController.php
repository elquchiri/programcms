<?php


namespace ElectroForums\CategoryBundle\Controller\Adminhtml;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    private $categoryRepository;
    private $toolbar;

    public function __construct(
        \ElectroForums\CategoryBundle\Repository\CategoryRepository $categoryRepository,
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->toolbar = $toolbar;
    }

    #[Route('/category/index', name: 'electroforums_category_tree')]
    public function categoryTree(): Response
    {
        $this->toolbar->addButton("Save", "", "primary");

        return $this->render('@ElectroForumsCategory/adminhtml/category_tree.html.twig', [
            'buttons' => $this->toolbar->getButtons(),
            'includeWebsiteSwitcher' => true
        ]);
    }

    #[Route('/category/edit/id/{id}', name: 'electroforums_category_tree_edit')]
    public function categoryEdit(
        \Symfony\Component\HttpFoundation\Request $request
    ): Response
    {
        $categoryId = $request->get('id');

        return $this->render('@ElectroForumsCategory/adminhtml/category_tree.html.twig', [

        ]);
    }

    #[Route('/category/save', name: 'electroforums_category_tree_save')]
    public function categorySave(
        \Symfony\Component\HttpFoundation\Request $request
    ): Response
    {
        $categoryId = $request->get('id');

        return $this->render('@ElectroForumsCategory/adminhtml/category_tree.html.twig', [

        ]);
    }

    #[Route('/category/create', name: 'electroforums_category_tree_create')]
    public function categoryCreate(
        \Symfony\Component\HttpFoundation\Request $request
    ): Response
    {
        return $this->render('@ElectroForumsCategory/adminhtml/category_tree.html.twig', [

        ]);
    }

    #[Route('/category/create/parent/{parent}', name: 'electroforums_category_tree_create_parent', requirements: ['parent' => '\d+'])]
    public function categoryCreateWithParent(
        \Symfony\Component\HttpFoundation\Request $request,
        $parent = ''
    ): Response
    {
        $parentCategory = $request->get('parent');

        return $this->render('@ElectroForumsCategory/adminhtml/category_tree.html.twig', [

        ]);
    }
}