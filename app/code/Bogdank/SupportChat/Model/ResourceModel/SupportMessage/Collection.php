<?php

declare(strict_types=1);


namespace Bogdank\SupportChat\Model\ResourceModel\SupportMessage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \Bogdank\SupportChat\Model\SupportMessage::class,
            \Klarna\Kp\Model\ResourceModel\Quote::class
        );
    }
}
