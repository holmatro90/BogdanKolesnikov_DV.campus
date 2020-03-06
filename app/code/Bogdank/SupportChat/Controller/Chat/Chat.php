<?php

declare (strict_types=1);

namespace Bogdank\SupportChat\Controller\Chat;

use Bogdank\SupportChat\Model\Support;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\DB\Transaction;

/**
 * Class Chat
 * @package Bogdank\SupportChat\Controller\Chat
 */
class Chat extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{

    /**
     * @var \Bogdank\SupportChat\Model\SupportFactory $supportFactory
     */
    private $supportFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    private $transactionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * Save constructor
     * @param \Bogdank\SupportChat\Model\SupportFactory $supportFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Action\Context $context
     */

    public function __construct(
        \Bogdank\SupportChat\Model\SupportFactory $supportFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Action\Context $context

    )
    {
        parent::__construct($context);
        $this->supportFactory = $supportFactory;
        $this->transactionFactory = $transactionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @return JsonResult
     */
    public function execute()
    {
        // @TODO: implement security layer when we get back to JS
        // @TODO: save data to customer session for guests
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();

        try {
            foreach ($this->getRequest()->getParam('message') as $messageText => $value) {
                /** @var Support $support */
                $support = $this->supportFactory->create();

                // @TODO: get `customer_id` from the session
                $support->setUserId(1)
                    ->setWebsiteId((int)$this->storeManager->getWebsite()->getId())
                    ->setMessage($messageText);

                $transaction->addObject($support);
            }
            $transaction->save();
            $message = __('Saved');

        } catch (\Exception $e) {
            $message = __('Your preferences can\'t be saved. Please, contact us if ypu see this message.');
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
