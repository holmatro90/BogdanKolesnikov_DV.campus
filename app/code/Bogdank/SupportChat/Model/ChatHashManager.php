<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Model;

class ChatHashManager
{
    public const CHAT_HASH = 'chat_hash';

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * ChatHashManager constructor.
     * @param \Magento\Customer\Model\Session $userSession
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $userSession,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
    ) {
        $this->customerSession = $userSession;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * @return string
     */
    public function getChatHash(): string
    {
        if (!$chatHash = $this->customerSession->getData(self::CHAT_HASH)) {
//            // if customer is logged in: get any of the customer messages by customer id and set hash,
//            // if no messages - generate it
            $chatHash = $this->generateChatHash();
            $this->customerSession->setChatHash($chatHash);
        }

        if ($this->customerSession->isLoggedIn()) {
            $updateChatHash = $this->messageCollectionFactory->create();
            $updateChatHash->addFieldToFilter('user_id', $this->customerSession->getCustomerId());

            $chatHash = $updateChatHash->getFirstItem()->getData('chat_hash');
            $this->customerSession->getChatHash($chatHash);
        }

        return $chatHash;
    }

    /**
     * @return string
     */
    private function generateChatHash(): string
    {
        return uniqid('', false);
    }
}
