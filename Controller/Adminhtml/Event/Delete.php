<?php
namespace Blackbird\TicketBlaster\Controller\Adminhtml\Event;

use Blackbird\TicketBlaster\Model\EventFactory;
use Magento\Backend\App\Action\Context;

class Delete extends \Magento\Backend\App\Action
{
    protected EventFactory $eventModelFactory;

    public function __construct(
        Context $context,
        EventFactory $eventModelFactory
    ) {
        parent::__construct($context);
        $this->eventModelFactory = $eventModelFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('event_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            /** @var \Blackbird\TicketBlaster\Model\Event $model */
            $model = $this->eventModelFactory->create();

            try {
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the event'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Blackbird_TicketBlaster::ticketblaster_event_delete');
    }
}
