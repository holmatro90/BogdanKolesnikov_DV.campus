<?php
declare(strict_types=1);

namespace Bogdank\SupportChat\Model;

use Bogdank\SupportChat\Api\Data\SupportChatInterface;

class SupportChatData extends \Magento\Framework\Api\AbstractSimpleObject implements
    \Bogdank\SupportChat\Api\Data\SupportChatInterface
{
    /**
     * @inheritDoc
     */
    public function getMessageId(): int
    {
        return (int) $this->_get(SupportChatInterface::MESSAGE_ID);
    }
    /**
     * @inheritDoc
     */
    public function setMessageId(int $messageId): SupportChatInterface
    {
        $this->setData(self::MESSAGE_ID, $messageId);

        return $this;
    }
    /**
     * @inheritDoc
     */
    public function getUserType(): string
    {
        return (string) $this->_get(SupportChatInterface::USER_TYPE);
    }
    /**
     * @inheritDoc
     */
    public function setUserType(string $userType): SupportChatInterface
    {
        $this->setData(self::USER_TYPE, $userType);

        return $this;
    }
    /**
     * @inheritDoc
     */
    public function getUserId(): int
    {
        return (int) $this->_get(SupportChatInterface::USER_ID);
    }
    /**
     * @inheritDoc
     */
    public function setUserId(int $userId): SupportChatInterface
    {
        $this->setData(self::USER_ID, $userId);

        return $this;
    }
    /**
     * @inheritDoc
     */
    public function getUserName(): string
    {
        return (string) $this->_get(SupportChatInterface::USER_NAME);
    }
    /**
     * @inheritDoc
     */
    public function setUserName(string $userName): SupportChatInterface
    {
        $this->setData(self::USER_NAME, $userName);

        return $this;
    }
    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return (string) $this->_get(SupportChatInterface::MESSAGE);
    }

    public function setMessage(string $message): SupportChatInterface
    {
        $this->setData(self::MESSAGE, $message);

        return $this;
    }
    /**
     * @inheritDoc
     */
    public function getWebsiteId(): int
    {
        return (int) $this->_get(SupportChatInterface::WEBSITE_ID);
    }
    /**
     * @inheritDoc
     */
    public function setWebsiteId(int $websiteId): SupportChatInterface
    {
        $this->setData(self::WEBSITE_ID, $websiteId);

        return $this;
    }

    public function getChatHash(): string
    {
        return (string) $this->_get(SupportChatInterface::CHAT_HASH);
    }
    /**
     * @inheritDoc
     */
    public function setChatHash(string $chatHash): SupportChatInterface
    {
        $this->setData(self::CHAT_HASH, $chatHash);

        return $this;
    }
    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return (string) $this->_get(SupportChatInterface::CREATED_AT);
    }
    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): SupportChatInterface
    {
        $this->setData(self::CREATED_AT, $createdAt);

        return $this;
    }
}
