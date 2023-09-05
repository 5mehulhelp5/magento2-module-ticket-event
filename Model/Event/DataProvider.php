<?php
namespace Blackbird\TicketBlaster\Model\Event;

use Blackbird\TicketBlaster\Model\ResourceModel\Event\CollectionFactory;
use Blackbird\TicketBlaster\Model\EventFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    private $request;

    protected $loadedData;

    protected EventFactory $eventModelFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $eventCollectionFactory,
        RequestInterface $request,
        EventFactory $eventModelFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $eventCollectionFactory->create();
        $this->request = $request;
        $this->eventModelFactory = $eventModelFactory;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $event = $this->getCurrentEvent();
        $this->loadedData[$event->getEventId()] = $event->getData();

        return $this->loadedData;
    }

    private function getEventId(): int
    {
        return (int) $this->request->getParam($this->getRequestFieldName());
    }

    private function getCurrentEvent()
    {
        /** @var \Blackbird\TicketBlaster\Model\Event $model */
        $model = $this->eventModelFactory->create();
        try {
            $model->load($this->getEventId());
            return $model;
        } catch (NoSuchEntityException $e) {
            return $model;
        }
    }
}
