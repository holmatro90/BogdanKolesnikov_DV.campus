<?php

declare (strict_types=1);

namespace Bogdank\SupportChat\Controller\Chat;

use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class Chat
 * @package Bogdank\SupportChat\Controller\Chat
 */
class Chat extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{

    /**
     * @return JsonResult
     */
    public function execute(): JsonResult
    {
        /**@var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'customerName' => $this->getRequest()->getParam('name'),
            'message' => $this->getRequest()->getParam('message')
        ]);

        return $response;
    }
}
