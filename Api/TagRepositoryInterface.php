<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\BlogGraphQl\Api;

interface TagRepositoryInterface
{
    /**
     * Retrieve Tag matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Ves\Blog\Api\Data\TagSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Retrieve Tag matching the specified criteria.
     * @param int $postId
     * @return \Ves\Blog\Model\ResourceModel\Tag\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListByPost(
        int $postId
    );
}

