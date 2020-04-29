<?php
declare(strict_types=1);

namespace Bogdank\SupportChat\Block\Adminhtml\Chat\Answer;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SendButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Send Answer Message'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
