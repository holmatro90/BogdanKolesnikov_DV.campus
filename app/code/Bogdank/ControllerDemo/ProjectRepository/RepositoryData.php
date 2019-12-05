<?php
declare(strict_types=1);


namespace Bogdank\ControllerDemo\ProjectRepository;

use Magento\Framework\View\Element\Template;

/**
 * Class RepositoryData
 * @package Bogdank\ControllerDemo\ProjectRepository
 */
class RepositoryData extends Magento\Framework\View\Element\Template
{
    /**
     * @var array
     */
    private $getRepository;

    /**
     * RepositoryData parameters
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->getRepository = $this->getRequest()->getParams();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getRepository['firstName'] . '' . $this->getRepository['lastName'];
    }

    public function getLink(): string
    {
        return $this->getRepository['githubRepository'];
    }

}