<?php

declare(strict_types=1);

namespace Bogdank\AskAboutThisProduct\Block;

class CustomerData extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Magento\Catalog\Block\Product\View
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Block\Product\View $productRepository
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Block\Product\View $productRepository
    ) {
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        if ($this->customerSession->isLoggedIn()) {
            $dataCustomer = $this->customerSession->getCustomerData();
            $name = $dataCustomer->getFirstname();
        } else {
            $name = '';
        }
        return $name;
    }

    /**
     * @return string
     */
    public function getCustomerEmail(): string
    {
        if ($this->customerSession->isLoggedIn()) {
            $email = $this->customerSession->getCustomerData()->getEmail();
        } else {
            $email = '';
        }
        return $email;
    }

    /**
     * @return string
     */
    public function getProductSku(): string
    {
        return $this->productRepository->getProduct()->getSku();
    }
}