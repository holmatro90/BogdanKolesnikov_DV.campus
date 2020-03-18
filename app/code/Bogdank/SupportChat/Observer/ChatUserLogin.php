<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Observer;

use Bogdank\SupportChat\Model\ResourceModel\SupportMessage\Collection as MessageCollection;
use Bogdank\SupportChat\Model\ChatHashManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ChatUserLogin implements ObserverInterface
{
    /**
     * @var \Bogdank\SupportChat\Model\ChatHashManager $generateHash
     */
    private $generateHash;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * ChatUserLogin constructor.
     * @param ChatHashManager $generateHash
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        \Bogdank\SupportChat\Model\ChatHashManager $generateHash,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
    ) {
        $this->generateHash = $generateHash;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Customer\Model\Data\Customer $customer */
        $customer = $observer->getData('customer');

        // 1. Find all messages from guest by current chat hash
        // 2. Find at least one message from this customer
        // 3. Set user_id to guest messages
        // 4. If there is a message from customer: set chat_hash to messages and to session (ChatHashManager::setChatHash())

        /** @var MessageCollection $chatCollection */
        $chatCollection = $this->messageCollectionFactory->create();
        $chatCollection->addFieldToFilter('chat_hash', $this->generateHash->getChatHash());


        $foo = false;
    }
}
