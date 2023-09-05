<?php
namespace Blackbird\TicketBlaster\Block\Adminhtml\Event\Edit;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Blackbird\TicketBlaster\Model\EventFactory;

class DeleteButton implements ButtonProviderInterface
{
    protected $context;

    protected EventFactory $eventModelFactory;

    public function __construct(
        Context $context,
        EventFactory $eventModelFactory
    ) {
        $this->context = $context;
        $this->eventModelFactory = $eventModelFactory;
    }

    public function getButtonData(): array
    {
        $data = [];
        if ($this->getEventId()) {
            $data = [
                'label' => __('Delete Event'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    public function getDeleteUrl()
    {
        return $this->context->getUrlBuilder()->getUrl('*/*/delete', ['page_id' => $this->getEventId()]);
    }

    public function getEventId(): ?int
    {
        /** @var \Blackbird\TicketBlaster\Model\Event $model */
        $model = $this->eventModelFactory->create();
        try {
            return $model->load(
                $this->context->getRequest()->getParam('event_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
