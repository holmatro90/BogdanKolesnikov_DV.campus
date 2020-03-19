<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Observer;

use Bogdank\SupportChat\Model\ChatHashManager;
use Bogdank\SupportChat\Model\ResourceModel\SupportMessage\Collection as MessageCollection;
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
     * @var \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    private $transactionFactory;

    /**
     * ChatUserLogin constructor.
     * @param ChatHashManager $generateHash
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Bogdank\SupportChat\Model\ChatHashManager $generateHash,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    )
    {
        $this->generateHash = $generateHash;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->transactionFactory = $transactionFactory;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Customer\Model\Data\Customer $customer */
        $customer = $observer->getData('customer');
        $this->updateChatMessagesData($customer);
    }

    /**
     * @param \Magento\Customer\Model\Data\Customer $customer
     * @throws \Exception
     */
    public function updateChatMessagesData($customer): void
    {
        $chatCollection = $this->messageCollectionFactory->create();
        /** @var \Magento\Framework\DB\Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        $chatCollection->addFieldToFilter('chat_hash', $this->generateHash->getChatHash());
        /** @var \Bogdank\SupportChat\Model\SupportMessage $supportMessage */
        foreach ($chatCollection as $supportMessage) {
            $supportMessage->setUserId((int)$customer->getId());
            $transaction->addObject($supportMessage);
            $transaction->save();
        }
    }
}
