<?php
declare (strict_types=1);


namespace Bogdank\ControllerDemo\Controller\Forward;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;

/**
 * Class Forward
 * @package Bogdank\ControllerDemo\Controller\Forward
 */
class Forward extends \Magento\Framework\App\Action\Action
{

    /** @var array */
    private const DATA = [
        'firstName' => 'Bogdan',
        'lastName' => 'Kolesnikov',
        'githubRepository' => 'https://github.com/holmatro90/magento_dv_campus'
    ];
    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * Forward constructor.
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    )
    {
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getData();
        $result = $this->resultForwardFactory->create();
        $result->setParams($data);
        $result->setController('data');
        $result->forward('data');
        return $result;
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return self::DATA;
    }
}
