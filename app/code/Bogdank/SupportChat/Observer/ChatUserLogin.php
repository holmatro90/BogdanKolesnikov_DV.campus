<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Observer;

use Bogdank\SupportChat\Model\GenerateHash;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ChatUserLogin implements ObserverInterface
{
    /**
     * @var \Bogdank\SupportChat\Model\GenerateHash $generateHash
     */
    private $generateHash;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * ChatUserLogin constructor.
     * @param GenerateHash $generateHash
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        \Bogdank\SupportChat\Model\GenerateHash $generateHash,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
    ) {
        $this->generateHash = $generateHash;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }
    public function execute(Observer $observer)
    {
        /** @var \Magento\Customer\Model\Data\Customer $customer */
        $customer = $observer->getData('customer');
        $this->updateChatMessages($customer);
    }

    private function updateChatMessages(): void
    {
        /** @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory */
        $chatCollection = $this->messageCollectionFactory->create();
        $chatCollection->addFieldToFilter('chat_hash', $this->generateHash->getChatHashCookie());
    }
}
