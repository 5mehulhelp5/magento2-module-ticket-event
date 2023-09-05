<?php
namespace Blackbird\TicketBlaster\Controller\Adminhtml\Event;

use Blackbird\TicketBlaster\Model\EventFactory;
use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
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
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Blackbird\TicketBlaster\Model\Event $model */
            $model = $this->eventModelFactory->create();
            $id = $this->getRequest()->getParam('event_id');
            if ($id) {
                $model->load($id);
            } else {
                $data['event_id'] = null;
            }
            $model->setData($data);
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this event'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Blackbird_TicketBlaster::ticketblaster_event_save');
    }
}
