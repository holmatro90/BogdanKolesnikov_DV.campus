<?php

declare(strict_types=1);


namespace Bogdank\SupportChat\Model\ResourceModel\SupportMessage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'message_id';
    protected $_eventPrefix = 'bogdank_supportchat_supportmessage_colection';
    protected $_eventObject = 'supportmessage_colection';
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \Bogdank\SupportChat\Model\SupportMessage::class,
            \Bogdank\SupportChat\Model\ResourceModel\SupportMessage::class
        );
    }
}
