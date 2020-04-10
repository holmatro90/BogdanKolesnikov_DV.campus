<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Observer;

use Bogdank\SupportChat\Model\ChatHashManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Tests\NamingConvention\true\mixed;

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
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * ChatUserLogin constructor.
     * @param ChatHashManager $generateHash
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Customer\Model\Session $userSession
     */
    public function __construct(
        \Bogdank\SupportChat\Model\ChatHashManager $generateHash,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Model\Session $userSession
    ) {
        $this->generateHash = $generateHash;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->transactionFactory = $transactionFactory;
        $this->logger = $logger;
        $this->customerSession = $userSession;
    }

    public function execute(Observer $observer)
    {
        try {
            /** @var \Magento\Customer\Model\Data\Customer $customer */
            $customer = $observer->getData('customer');
            $this->updateChatMessagesData($customer);
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }

    /**
     * @param \Magento\Customer\Model\Data\Customer $customer
     * @throws \Exception
     */
    public function updateChatMessagesData($customer): void
    {
        if ($this->customerSession->isLoggedIn()) {
            $userId = (int)$this->customerSession->getId();

            if (!$chatHash = $this->customerSession->getChatHash()) {
                $oldChatHash = $this->findOldChatHash($userId);
                if ($oldChatHash !== null) {
                    $this->customerSession->setChatHash($oldChatHash);
                }
            } else {
                $oldChatHash = $this->findOldChatHash($userId);
                if ($oldChatHash === null) {
                    $oldChatHash = $this->customerSession->getChatHash();
                }

                $chatCollection = $this->messageCollectionFactory->create();
                $chatCollection->addChatHashFilter($chatHash);

                $transaction = $this->transactionFactory->create();
                foreach ($chatCollection as $oldMessage) {
                    if ((int)$oldMessage->getUserId() !== $userId) {
                        $oldMessage->setUserId($userId)
                            ->setChatHash($oldChatHash);
                    }
                    $transaction->addObject($oldMessage);
                }
                $transaction->save();

                $this->customerSession->setChatHash($oldChatHash);
            }
        }
    }

    /**
     * @param $userId
     * @return mixed
     */
    private function findOldChatHash($userId)
    {
        $chatCollection = $this->messageCollectionFactory->create();
        $chatCollection->addCustomerFilter($userId);
        return $chatCollection->getFirstItem()->getData('chat_hash');
    }
}
