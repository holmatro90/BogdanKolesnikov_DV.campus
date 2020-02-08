<?php
declare (strict_types=1);

namespace Bogdank\SupportChat\Controller\Chat;

use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;


/**
 * Class Chat
 * @package Bogdank\SupportChat\Controller\Chat
 */
class Chat extends \Magento\Framework\App\Action\Action implements
    \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @inheritDoc
     */

        public function execute()
        {
            /**@var JsonResult $response */
            $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $response->setData([
                'message' => 'Send'
            ]);

            return $response;
        }
}