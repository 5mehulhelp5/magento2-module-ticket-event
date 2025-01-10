<?php
namespace Blackbird\TicketBlaster\Model\Event\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Blackbird\TicketBlaster\Model\ResourceModel\Event\Collection as EventCollection;

class Event extends Table
{
    public function __construct(
        CollectionFactory $attrOptionCollectionFactory,
        OptionFactory $attrOptionFactory,
        private EventCollection $eventCollection,
        StoreManagerInterface $storeManager = null
    ) {
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory, $storeManager);
    }

    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        $events = $this->eventCollection;
        $options[] = ['label' => '', 'value' => ''];
        foreach ($events as $event) {
            $options[] = ['label' => $event->getTitle(), 'value' => $event->getId()];
        }

        return $options;
    }
}
