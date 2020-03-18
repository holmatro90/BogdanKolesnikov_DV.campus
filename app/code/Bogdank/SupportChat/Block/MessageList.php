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

    /**
     * @var \Bogdank\SupportChat\Model\GenerateHash $generateHash
     */
    private $generateHash;

    /**
     * MessageList constructor.
     * @param CollectionFactory $messageCollectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Bogdank\SupportChat\Model\GenerateHash $generateHash,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->generateHash = $generateHash;
    }

    public function getChatHashCookie(): ?string
    {
        return $this->generateHash->getChatHashCookie();
    }

    /**
     * @return Collection
     */
    public function getLastMessages()
    {
        /** @var Collection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();
        $messageCollection->setOrder('created_at', $messageCollection::SORT_ORDER_DESC)
        ->setPageSize(10);
        if ($this->generateHash->getUserId()) {
            $messageCollection->addFieldToFilter('user_id', $this->generateHash->getUserId());
        } else {
            $messageCollection->addFieldToFilter('chat_hash', $this->generateHash->getChatHashCookie());
        }

        return $messageCollection;
    }
    /**
     * Setting chatHashCookie
     *
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException
     * @throws \Magento\Framework\Stdlib\Cookie\FailureToSendException
     */
    private function setChatHashCookie(): void
    {
        $chatHashCookie = $this->generateHash->getChatHashCookie();
        if ($chatHashCookie === 'chat_hash') {
            $this->generateHash->setChatHash($this->generateHash->generateChatHash());
        }
    }
    protected function _beforeToHtml()
    {
        $this->setChatHashCookie();
        return parent::_beforeToHtml();
    }
}
