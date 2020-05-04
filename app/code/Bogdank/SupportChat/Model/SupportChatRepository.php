<?php

declare(strict_types=1);

namespace Bogdank\SupportChat\Model;

use Bogdank\SupportChat\Api\Data\SupportChatInterface;
use Bogdank\SupportChat\Api\Data\SupportChatSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;

class SupportChatRepository implements \Bogdank\SupportChat\Api\SupportChatRepositoryInterface
{
    /**
     * @var \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $supportMessageCollectionFactory
     */
    private $supportMessageCollectionFactory;

    /**
     * @var \Bogdank\SupportChat\Api\Data\SupportChatSearchResultInterfaceFactory $searchResultsFactory
     */
    private $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     **/
    private $collectionProcessor;

    /**
     * @var \Bogdank\SupportChat\Api\Data\SupportChatInterfaceFactory $supportChatDataFactory
     */
    private $supportChatDataFactory;

    /**
     * @var \Magento\Framework\EntityManager\EntityManager $entityManager
     */
    private $entityManager;

    /**
     * PreferenceRepository constructor.
     * @param \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $supportMessageCollectionFactory
     * @param \Bogdank\SupportChat\Api\Data\SupportChatSearchResultInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Bogdank\SupportChat\Api\Data\SupportChatInterfaceFactory $supportChatDataFactory
     * @param \Magento\Framework\EntityManager\EntityManager $entityManager
     */
    public function __construct(
        \Bogdank\SupportChat\Model\ResourceModel\SupportMessage\CollectionFactory $supportMessageCollectionFactory,
        \Bogdank\SupportChat\Api\Data\SupportChatSearchResultInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Bogdank\SupportChat\Api\Data\SupportChatInterfaceFactory $supportChatDataFactory,
        \Magento\Framework\EntityManager\EntityManager $entityManager
    ) {
        $this->supportMessageCollectionFactory = $supportMessageCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->supportChatDataFactory = $supportChatDataFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SupportChatSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SupportChatSearchResultInterface
    {
        $supportMessageCollection = $this->supportMessageCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $supportMessageCollection);
        $message = [];

        /** @var Message $message */
        foreach ($supportMessageCollection as $message) {
            $data = $message->getData();
            $data['id'] = $message->getId();
            $data['message_id'] = $message->getMessageId();
            $data['user_name'] = $message->getUserName();
            $data['message'] = $message->getMessage();
            $data['created_at'] = $message->getCreatedAt();
            $message[] = $this->supportChatDataFactory->create(['data' => $data]);
        }

        /** @var SupportChatSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setTotalCount($supportMessageCollection->getSize());
        $searchResults->setItems($message);

        return $searchResults;
    }

    /**
     * @inheritDoc
     * @throws CouldNotSaveException
     */
    public function save(SupportChatInterface $supportChat): SupportChatInterface
    {
        try {
            $this->entityManager->save($supportChat);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $supportChat;
    }

    /**
     * @inheritdoc
     */
    public function delete(SupportChatInterface $supportChat): bool
    {
        try {
            $this->entityManager->delete($supportChat);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $messageId): bool
    {
        return $this->delete($this->get($messageId));
    }
}
