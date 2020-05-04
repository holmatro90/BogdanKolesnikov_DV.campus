<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\CustomerData;

use Bogdank\SupportChat\Model\SupportChatData;

class CustomerMessage implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager
     */
    private $chatHashManager;

    /**
     * @var \Bogdank\SupportChat\Model\SupportChatRepository $supportChatRepository
     */
    private $supportChatRepository;

    /**
     * @var \Magento\Framework\Api\FilterBuilder $filterBuilder
     */
    private $filterBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * CustomerMessage constructor.
     * @param \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager
     * @param \Bogdank\SupportChat\Model\SupportChatRepository $supportChatRepository
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager,
        \Bogdank\SupportChat\Model\SupportChatRepository $supportChatRepository,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->chatHashManager = $chatHashManager;
        $this->supportChatRepository = $supportChatRepository;
        $this->filterBuilder = $filterBuilder;
        $this->storeManager = $storeManager;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->customerSession = $customerSession;
    }

    /**
     * @inheritDoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSectionData(): array
    {
        $data = [];

        $this->searchCriteriaBuilder->addFilters([
            $this->filterBuilder
                ->setField('chat_hash')
                ->setValue($this->chatHashManager->getChatHash())
                ->setConditionType('eq')
                ->create(),
            $this->filterBuilder
                ->setField('website_id')
                ->setValue((int) $this->storeManager->getWebsite()->getId())
                ->setConditionType('eq')
                ->create()
        ]);

        /** @var SupportChatData $supportMessages */
        foreach ($supportMessages as $supportMessage) {
            $data[] = $supportMessage->getData();
        }

        return [
            'messages' => $data
        ];
    }
}
