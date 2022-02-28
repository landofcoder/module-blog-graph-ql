<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\BlogGraphQl\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Ves\Blog\Api\PostManagementInterface;

class Blog implements ResolverInterface
{
    /**
     * @var PostManagementInterface
     */
    private $postManagement;

    /**
     * @var PostManagementInterface $postManagement
     */
    public function __construct(
        PostManagementInterface $postManagement
    )
    {
        $this->postManagement = $postManagement;
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
        if (empty($args['post_id'])) {
            throw new GraphQlInputException(__('Post Id is required.'));
        }
        $post = $this->postManagement->get($args['post_id']);
        if (!$post || !$post->getIsActive()) {
            throw new GraphQlInputException(__('Post Id does not match any Post.'));
        }
        return $post;
    }
}
