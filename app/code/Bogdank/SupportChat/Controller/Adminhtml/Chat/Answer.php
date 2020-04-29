<?php
declare(strict_types=1);

namespace Bogdank\SupportChat\Controller\Adminhtml\Chat;

use Magento\Framework\Controller\ResultFactory;

class Answer extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Bogdank_SupportChat::answer';
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $messageList = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $messageList->getConfig()->getTitle()->set(__('Support Messages List'));

        if ($this->getRequest()->getParam('chat_hash')) {
            $messageList->getConfig()->getTitle()->prepend(__('Chat with user'));
        }

        return $messageList;
    }
}