<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\CustomerData;

use Bogdank\SupportChat\Model\ResourceModel\SupportMessage\Collection as MessageCollection;
use Bogdank\SupportChat\Model\SupportMessage;

class CustomerMessage implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager
     */
    private $chatHashManager;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * CustomerMessage constructor.
     * @param \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->chatHashManager = $chatHashManager;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
    }

    /**
     * @inheritDoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSectionData(): array
    {
        $data = [];
        /** @var MessageCollection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();
        $messageCollection->addFieldToFilter('chat_hash', $this->chatHashManager->getChatHash())
            ->addWebsiteFilter((int) $this->storeManager->getWebsite()->getId());

        /** @var SupportMessage $userMessage */
        foreach ($messageCollection as $supportMessage) {
            $data[] = $supportMessage->getData();

            if ($this->customerSession->isLoggedIn()) {
                $chatCollection = $this->messageCollectionFactory->create();
                $chatCollection->addCustomerFilter((int) $this->customerSession->getId())
                    ->addWebsiteFilter((int) $this->storeManager->getWebsite()->getId());

                $data = $chatCollection->getData();
            }
        }

        return $data;
    }
}
