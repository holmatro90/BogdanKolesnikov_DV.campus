<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Api;

use Bogdank\SupportChat\Api\Data\SupportChatSearchResultInterface;
use Bogdank\SupportChat\Api\Data\SupportChatInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface SupportChatRepositoryInterface
{

    /**
     * Save support messages
     *
     * @param SupportChatInterface $supportChat
     * @return SupportChatInterface
     */
    public function save(SupportChatInterface $supportChat): SupportChatInterface;

    /**
     * Get customer support message by message_id
     *
     * @param int $messageId
     * @return SupportChatInterface
     */
    public function get(int $messageId): SupportChatInterface;

    /**
     * Get support messages list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Bogdank\SupportChat\Api\Data\SupportChatSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SupportChatSearchResultInterface;

    /**
     * Delete support messages object
     *
     * @param SupportChatInterface $supportChat
     * @return bool
     */
    public function delete(SupportChatInterface $supportChat): bool;

    /**
     * Delete support messages by message_id
     *
     * @param int $messageId
     * @return bool
     */
    public function deleteById(int $messageId): bool;
}
