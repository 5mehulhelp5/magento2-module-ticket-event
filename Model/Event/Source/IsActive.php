<?php
namespace Blackbird\TicketBlaster\Model\Event\Source;

class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $event;

    public function __construct(\Blackbird\TicketBlaster\Model\Event $event)
    {
        $this->event = $event;
    }
    public function toOptionArray()
    {
        $availableOptions = $this->event->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
