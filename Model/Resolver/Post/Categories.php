<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\BlogGraphQl\Model\Resolver\Post;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Ves\Blog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class Categories implements ResolverInterface
{

    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        CategoryCollectionFactory $categoryCollectionFactory
    )
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['post_id']) || empty($value['post_id'])) {
            throw new GraphQlInputException(__('post_id value must be greater than 0.'));
        }

        $store = $context->getExtensionAttributes()->getStore();

        $collection = $this->categoryCollectionFactory->create();
        $collection->addFieldToFilter("is_active", 1);
        $collection->addStoreFilter($store);
        $collection->addPostToFilter((int)$value['post_id']);

        return [
            'total_count' => $collection->getSize(),
            'items'       => $collection->getItems()
        ];
    }
}
