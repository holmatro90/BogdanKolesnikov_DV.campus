<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Block;

use Bogdank\SupportChat\Model\ResourceModel\SupportMessage\Collection;
use Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory;

class MessageList extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CollectionFactory
     */
    private $messageCollectionFactory;

    public function __construct(
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->messageCollectionFactory = $messageCollectionFactory;
    }
    /**
     * @param string $ChatHash
     * @return Collection
     */
    public function getLastMessages(string $chatHash): Collection
    {
        /** @var Collection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();
        return $messageCollection->addFieldToFilter('chat_hash', $chatHash)
        ->setOrder('created_at', $messageCollection::SORT_ORDER_DESC)
        ->setPageSize(10);
    }
}
