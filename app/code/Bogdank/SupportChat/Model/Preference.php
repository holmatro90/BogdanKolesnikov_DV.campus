<?php

declare(strict_types=1);


namespace Bogdank\SupportChat\Model;


class Preference extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\Bogdank\SupportChat\Model\ResourceModel\Preference::class);
    }
}