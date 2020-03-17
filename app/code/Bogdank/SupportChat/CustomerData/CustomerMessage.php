<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\CustomerData;

use Bogdank\SupportChat\Model\ResourceModel\SupportMessage\Collection as MessageCollection;

class CustomerMessage implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $userSession;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    private $generateHash;

    /**
     * CustomerMessage constructor.
     * @param \Magento\Customer\Model\Session $userSession
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Customer\Model\Session $userSession,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->userSession = $userSession;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSectionData(): array
    {
        /** @var MessageCollection $MessageCollection */
        $messageCollection = $this->messageCollectionFactory->create();
        $data = [];

        /** @var Chat $message */
        foreach ($messageCollection as $message) {
            $data[] = $message->getData();

            if ($this->userSession->isLoggedIn()) {
                /** @var messageCollection $messageCollection */
                $messageCollection = $this->messageCollectionFactory->create();
                $messageCollection->addCustomerFilter((int) $this->userSession->getId())
                    ->addWebsiteFilter((int) $this->storeManager->getWebsite()->getId());

                $data = $messageCollection->getData()[0];
            } else {
                $data = $this->userSession->getData('customer_message') ?? [];
            }

            return $data;
        }
    }
}
