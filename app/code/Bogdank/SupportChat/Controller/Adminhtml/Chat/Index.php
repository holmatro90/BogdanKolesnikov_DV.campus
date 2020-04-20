<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Controller\Adminhtml\Chat;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Bogdank_SupportChat::listing';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $messageList = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $messageList->getConfig()->getTitle()->set(__('Support Message List'));
        return $messageList;
    }
}
