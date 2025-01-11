<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model\Search;

use ProgramCms\PostBundle\Model\Collection\Collection;

/**
 * Class Post
 * @package ProgramCms\PostBundle\Model\Search
 */
class Post
{
    /**
     * @var Collection
     */
    protected Collection $collection;

    /**
     * Post constructor.
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection
    )
    {
        $this->collection = $collection;
    }

    /**
     * @param array $filters
     * @return array
     */
    public function getResults(array $filters): array
    {
        $data = [];
        if(isset($filters['q'])) {
            $data = $this->collection
                ->addAttributeToFilter('post_html', $filters['q'], 'like')
                ->getData();
        }

        return [
            'data' => $data,
            'count' => count($data)
        ];
    }

}