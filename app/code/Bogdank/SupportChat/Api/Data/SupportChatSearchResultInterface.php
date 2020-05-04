<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Api\Data;

/**
 * Must redefine the interface methods for \Magento\Framework\Reflection\DataObjectProcessor::buildOutputDataArray()
 * Must not declare return types to keep the interface consistent with the parent interface
 */
interface SupportChatSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Bogdank\SupportChat\Api\Data\SupportChatInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \Bogdank\SupportChat\Api\Data\SupportChatInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
