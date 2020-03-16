<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\CustomerData;

class CustomerMessage implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Custommer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * CustomerPreferences constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $messageCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->customerSession = $customerSession;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData(): array
    {
        // @TODO: we must deal with deleted attributes or deleted attribute options
        if ($this->customerSession->isLoggedIn()) {
            $data = [];
            /** @var MessageCollection $messageCollectionFactory */
            $messageCollection = $this->messageCollectionFactory->create();
            $messageCollection->addCustomerFilter((int) $this->customerSession->getId())
                ->addWebsiteFilter((int) $this->storeManager->getWebsite()->getId());

            /** @var Preference $customerMessage */
            foreach ($messageCollection as $customerMessage) {
                $data[$customerMessage->getAttributeCode()] = $customerMessage->getPreferredValues();
            }
        } else {
            $data = $this->customerSession->getData('customer_preferences') ?? [];
        }

        return $data;
    }
}
