<?php
declare(strict_types=1);

namespace Bogdank\SupportChat\Model;

use Bogdank\SupportChat\Api\Data\SupportChatInterface;

class SupportChatManagement
{
    /**
     * @var \Bogdank\SupportChat\Model\SupportChatRepository $supportChatRepository
     */
    private $supportChatRepository;

    /**
     * @var \Magento\Framework\Api\FilterBuilder $filterBuilder
     */
    private $filterBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * SupportChat constructor.
     * @param \Bogdank\SupportChat\Model\SupportChatRepository $supportChatRepository
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        \Bogdank\SupportChat\Model\SupportChatRepository $supportChatRepository,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->supportChatRepository = $supportChatRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param string $chatHash
     * @param int $websiteId
     * @return SupportChatInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSupportChat(string $chatHash, int $websiteId): array
    {
        $this->searchCriteriaBuilder->addFilters([
            $this->filterBuilder
                ->setField('chat_hash')
                ->setValue($chatHash)
                ->setConditionType('eq')
                ->create(),
            $this->filterBuilder
                ->setField('website_id')
                ->setValue($websiteId)
                ->setConditionType('eq')
                ->create()
        ]);

        return $this->supportChatRepository->getList($this->searchCriteriaBuilder->create())
            ->getItems();
    }
}
