<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\BlogGraphQl\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Lof\BlogGraphQl\Api\GetPostRepositoryInterface;
use Ves\Blog\Helper\Data;
use Ves\Blog\Model\PostFactory;
use Ves\Blog\Model\ResourceModel\Post as ResourcePost;

/**
 * get Post repository model
 */
class GetPostRepository implements GetPostRepositoryInterface
{

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ResourcePost
     */
    private $resource;

    /**
     * Initialize dependencies.
     *
     * @param Data $data
     * @param StoreManagerInterface $storeManager
     * @param PostFactory $postFactory
     * @param ResourcePost $resource
     */
    public function __construct(
        Data $data,
        StoreManagerInterface $storeManager,
        PostFactory $postFactory,
        ResourcePost $resource
    ) {
        $this->helper = $data;
        $this->storeManager = $storeManager;
        $this->postFactory = $postFactory;
        $this->resource = $resource;
    }

    /**
     * @inheritdoc
     */
    public function get($id, $storeId = null)
    {
        try {
            $item = $this->postFactory->create();
            $this->resource->load($item, (int)$id);

            if (!$item->getId()) {
                return false;
            }

            if ($storeId !== null && !$item->isVisibleOnStore($storeId)) {
                return false;
            }

            $item->setImage($item->getImageUrl());
            $item->setThumbnail($item->getThumbnailUrl());
            return $item;
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__('Blog Post with id "%1" does not exist.', $id));
        }
    }
}
