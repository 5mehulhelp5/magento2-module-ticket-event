<?php
namespace Blackbird\TicketBlaster\Model\Event\Source;
class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        return $options;
    }
}
