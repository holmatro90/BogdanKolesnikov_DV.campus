<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Controller\SupportMessage;

use Bogdank\SupportChat\Model\SupportMessage;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Send extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Bogdank_SupportChat::answer';

    /**
     * @var \Bogdank\SupportChat\Model\SupportMessageFactory $supportMessageFactory
     */
    private $supportMessageFactory;

    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage $supportMessageResource
     */
    private $supportMessageResource;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager
     */
    private $chatHashManager;

    /**
     * Save constructor
     * @param \Bogdank\SupportChat\Model\SupportMessageFactory $supportMessageFactory
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage $supportMessageResource
     * @param \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Bogdank\SupportChat\Model\SupportMessageFactory $supportMessageFactory,
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage $supportMessageResource,
        \Bogdank\SupportChat\Model\ChatHashManager $chatHashManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->supportMessageFactory = $supportMessageFactory;
        $this->supportMessageResource = $supportMessageResource;
        $this->chatHashManager = $chatHashManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        try {
            $request = $this->getRequest();

            if (!$this->formKeyValidator->validate($request)) {
                throw new LocalizedException(__('Something get wrong'));
            }

            // @TODO: get user type
            $userType = 'admin';
            $userName = 'Administrator';
            /** @var SupportMessage $supportMessage */
            $supportMessage = $this->supportMessageFactory->create();
            $supportMessage->setUserId((int)$this->customerSession->getId())
                ->setChatHash($this->chatHashManager->getChatHash())
                ->setWebsiteId((int) $this->storeManager->getWebsite()->getId())
                ->setUserName($this->getRequest()->getParam('name'))
                ->setUserType($userType)
                ->setMessage($this->getRequest()->getParam('message'));
            $this->supportMessageResource->save($supportMessage);
            $message = __('Success');
        } catch (\Exception $e) {
            $message = __('Your message can\'t be send');
        }

        /**@var JsonResult $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData([
            'message' => $message
        ]);

        return $response;
    }
}
