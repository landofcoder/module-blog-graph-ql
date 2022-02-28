<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\BlogGraphQl\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface BlogRepositoryInterface
 * @package Lof\BlogGraphQl\Api
 */
interface BlogRepositoryInterface
{

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Ves\Blog\Api\Data\PostSearchResultsInterface
     */
    public function getListPost(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );
}
