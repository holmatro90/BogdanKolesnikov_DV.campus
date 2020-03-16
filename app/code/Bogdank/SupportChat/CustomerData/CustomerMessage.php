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
}
