<?php
namespace Blackbird\TicketBlaster\Ui\DataProvider\Event\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    public function setItems(array $items = null)
    {
        return $this;
    }
    /**
     * Override _initSelect to add custom columns
     *
     * @return void
     */
    protected function _initSelect()
    {
        $this->addFilterToMap('event_id', 'main_table.event_id');
        //$this->addFilterToMap('name', 'devgridname.value');
        parent::_initSelect();
    }
}
