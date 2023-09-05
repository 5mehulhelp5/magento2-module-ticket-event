<?php

namespace Blackbird\TicketBlaster\Model\ResourceModel\Event;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'event_id';

    protected function _construct()
    {
        $this->_init('Blackbird\TicketBlaster\Model\Event', 'Blackbird\TicketBlaster\Model\ResourceModel\Event');
    }
}
