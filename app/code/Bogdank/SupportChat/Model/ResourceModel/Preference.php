<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Model\ResourceModel;


class Preference extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('bogdank_support_chat', 'message_id');
    }
}
