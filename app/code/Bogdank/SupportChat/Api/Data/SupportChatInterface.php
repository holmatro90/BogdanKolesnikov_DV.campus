<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Api\Data;

interface SupportChatInterface
{
    public const MESSAGE_ID = 'message_id';

    public const USER_TYPE = 'user_type';

    public const USER_ID = 'user_id';

    public const USER_NAME = 'user_name';

    public const MESSAGE = 'message';

    public const WEBSITE_ID = 'website_id';

    public const CHAT_HASH = 'chat_hash';

    public const CREATED_AT = 'created_at';

    /**
     * @return int
     */
    public function getMessageId(): int;

    /**
     * @param int $messageId
     * @return $this
     */
    public function setMessageId(int $messageId): self;

    /**
     * @return int
     */
    public function getUserType(): string;

    /**
     * @param string $userType
     * @return $this
     */
    public function setUserType(string $userType): self;

    /**
     * @return int
     */
    public function getUserId(): int;

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId): self;

    /**
     * @return string
     */
    public function getUserName(): string;

    /**
     * @param string $userName
     * @return $this
     */
    public function setUserName(string $userName): self;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self;

    /**
     * @return int
     */
    public function getWebsiteId(): int;

    /**
     * @param int $websiteId
     * @return $this
     */
    public function setWebsiteId(int $websiteId): self;

    /**
     * @return string
     */
    public function getChatHash(): string;

    /**
     * @param string $chatHash
     * @return $this
     */
    public function setChatHash(string $chatHash): self;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @param string|null $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;
}
