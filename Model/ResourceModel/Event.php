<?php

namespace Blackbird\TicketBlaster\Model\ResourceModel;

class Event extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('blackbird_ticketblaster_event', 'event_id');
    }
}
