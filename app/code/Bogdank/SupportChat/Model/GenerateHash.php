<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Model;

use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;

class GenerateHash
{

    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     */
    private $cookieManager;

    private $cookieMetadataFactory;

    /**
     * @var \Magento\Customer\Model\Session $userSession
     */
    private $userSession;

    public function __construct(
        \Magento\Framework\Stdlib\Cookie\PublicCookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Customer\Model\Session $userSession
    ) {
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->userSession = $userSession;
    }

    public function getUserId(): ?int
    {
        return (int)$this->userSession->getCustomerId();
    }

    public function generateChatHash(): string
    {
        return uniqid('', false);
    }

    /**
     * @param string $chatHash
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException
     * @throws \Magento\Framework\Stdlib\Cookie\FailureToSendException
     */
    public function setChatHash(string $chatHash)
    {
        /** @var PublicCookieMetadata $meta */
        $meta = $this->cookieMetadataFactory->create();
        $meta->setPath($this->userSession->getCookiePath());
        $meta->setDomain($this->userSession->getCookieDomain());
        $meta->setDuration($this->userSession->getCookieLifetime());
        $this->cookieManager->setPublicCookie(self::CHAT_HASH, $chatHash, $meta);
    }
    /**
     * Chat hash
     */
    const CHAT_HASH = 'chat_hash';

    /**
     * @return string|null
     */
    public function getChatHashCookie(): ?string
    {
        return $this->cookieManager->getCookie(self::CHAT_HASH, 'chat_hash');
    }
}
