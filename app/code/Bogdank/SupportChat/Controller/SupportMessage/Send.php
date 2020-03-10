<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Controller\SupportMessage;

use Bogdank\SupportChat\Model\SupportMessage;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Send extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Bogdank\SupportChat\Model\SupportMessageFactory $supportMessageFactory
     */
    private $supportMessageFactory;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage $supportMessageResource
     */
    private $supportMessageResource;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * Save constructor
     * @param \Bogdank\SupportChat\Model\SupportMessageFactory $supportMessageFactory
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage $supportMessageResource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Bogdank\SupportChat\Model\SupportMessageFactory $supportMessageFactory,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage $supportMessageResource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->supportMessageFactory = $supportMessageFactory;
        $this->supportMessageResource = $supportMessageResource;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        // @TODO: implement security layer when we get back to JS
        // @TODO: save data to customer session for guests

        try {
            $request = $this->getRequest();

            if (!$request->getParam('message') || !$request->getParam('name')) {
                throw new LocalizedException(__('Name and message should not be empty'));
            }

            // @TODO: generate chat hash if not present in the customer session
            $chatHash = 'test_chat_hash';
            // @TODO: get user type
            $userType = 'customer';
            /** @var SupportMessage $supportMessage */
            $supportMessage = $this->supportMessageFactory->create();

            //@TODO: get `customer_id` from the session
            $supportMessage->setUserId(1)
                ->setChatHash($chatHash)
                ->setWebsiteId((int)$this->storeManager->getWebsite()->getId())
                 ->setUserName($this->getRequest()->getParam('name'))
                 ->setUserType($userType)
                ->setMessage($this->getRequest()->getParam('message'));
            $this->supportMessageResource->save($supportMessage);

        } catch (\Exception $e) {
            $message = __('Your preferences can\'t be saved. Please, contact us if you see this message.');
        }

        /**@var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'customerName' => $this->getRequest()->getParam('name'),
            'message' => $this->getRequest()->getParam('message')
        ]);

        return $response;
    }
}
