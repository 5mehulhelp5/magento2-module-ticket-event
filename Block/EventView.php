<?php
namespace Blackbird\TicketBlaster\Block;

use Blackbird\TicketBlaster\Model\Event;
use Blackbird\TicketBlaster\Model\EventFactory;
use Magento\Framework\View\Element\Template;

class EventView extends Template
{
    public function __construct(
        Template\Context $context,
        private EventFactory $eventFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        $event = $this->eventFactory->create();
        if ($id = $this->getRequest()->getParam('id')) {
            $event = $event->load($id);
        }

        return $event;
    }
}
