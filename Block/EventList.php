<?php
namespace Blackbird\TicketBlaster\Block;

use Blackbird\TicketBlaster\Model\ResourceModel\Event\Collection as EventCollection;
use Magento\Framework\View\Element\Template;

class EventList extends Template
{
    public function __construct(
        Template\Context $context,
        private EventCollection $eventCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return EventCollection
     */
    public function getEvents(): EventCollection
    {
        return $this->eventCollection;
    }
}
