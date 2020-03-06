<?php

declare(strict_types=1);


namespace Bogdank\SupportChat\Model;

use http\Message;
use Magento\Framework\Exception\LocalizedException;

/**
 * @method int getMessageId()
 * @method $this setMessageId(int $messageId)
 * @method int getUserId()
 * @method $this setUserId(int $userId)
 * @method int getMessage()
 * @method $this setMessage(string $message)
 * @method int getWebsiteId()
 * @method $this setWebsiteId(int $websiteId)
 */
class Support extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\Bogdank\SupportChat\Model\ResourceModel\Support::class);
    }

    public function beforeSave(): self
    {
        parent::beforeSave();

        // @TODO: see the AbstractModel::validateBeforeSave() method and its' implementation for better implementation
        $this->validate();

        return $this;
    }


    /**
     * @throws LocalizedException
     */
    public function validate(): void
    {
        if (!$this->getUserId()) {
            throw new LocalizedException(__('Can\'t send message: %s is not set.', 'user_id'));
        }
        if (!$this->getWebsiteId()) {
            throw new LocalizedException(__('Can\'t send message: %s is not set.', 'website_id'));
        }

    }
}