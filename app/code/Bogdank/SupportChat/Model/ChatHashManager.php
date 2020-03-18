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
     * ChatHashManager constructor.
     * @param \Magento\Customer\Model\Session $userSession
     */
    public function __construct(
        \Magento\Customer\Model\Session $userSession
    ) {
        $this->customerSession = $userSession;
    }

    /**
     * @return string
     */
    public function getChatHash(): string
    {
        if (!$chatHash = $this->customerSession->getData(self::CHAT_HASH)) {
            $chatHash = $this->generateChatHash();
            $this->customerSession->setChatHash($chatHash);
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
