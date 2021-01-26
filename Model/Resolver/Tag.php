<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\BlogGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Ves\Blog\Api\PostRepositoryInterface;
use Ves\Blog\Api\TagRepositoryInterface;
use Ves\Blog\Model\ResourceModel\Tag\Collection;

/**
 * Class Tag
 * @package Lof\BlogGraphQl\Model\Resolver
 */
class Tag implements ResolverInterface
{


    /**
     * @var TagRepositoryInterface
     */
    private $tagManagement;
    /**
     * @var Collection
     */
    private $tagCollection;
    /**
     * @var PostRepositoryInterface
     */
    private $postRepositoryInterface;

    /**
     * Tag constructor.
     * @param TagRepositoryInterface $tagManagement
     * @param Collection $tagCollection
     * @param PostRepositoryInterface $postRepositoryInterface
     */
    public function __construct(
        TagRepositoryInterface $tagManagement,
        Collection $tagCollection,
        PostRepositoryInterface $postRepositoryInterface
    )
    {
        $this->tagManagement = $tagManagement;
        $this->tagCollection = $tagCollection;
        $this->postRepositoryInterface = $postRepositoryInterface;

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
        if (!isset($args['alias']) || !$args['alias']) {
            throw new GraphQlInputException(__('"Alias" can\'t be empty.'));
        }
        $collection = $this->tagCollection->addFieldToFilter('alias' , $args['alias']);
        if (!$collection->getData()) {
            throw new GraphQlInputException(__('This Tag does not exist.'));
        }
        $tag = $collection->getFirstItem();
        $posts = [];
        $postIds = [];
        foreach ($collection as $item) {
            $post = $this->postRepositoryInterface->get($item->getPostId());
            $postIds[] = $item->getPostId();
            if($post) {
                $posts[] = $post;
            }
        }
        $postItems['total_count'] = count($collection);
        $postItems['items'] = $posts;
        $tag->setPosts($postItems)->setPostId($postIds);
        return $tag;
    }
}
