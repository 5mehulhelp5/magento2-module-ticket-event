<?php
namespace Blackbird\TicketBlaster\Controller\Adminhtml\Event;

use Blackbird\TicketBlaster\Model\EventFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Magento\Backend\App\Action
{
    protected PageFactory $resultPageFactory;

    protected EventFactory $eventModelFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        EventFactory $eventModelFactory
    ) {
        parent::__construct($context);
        $this->eventModelFactory = $eventModelFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('event_id');
        /** @var \Blackbird\TicketBlaster\Model\Event $model */
        $model = $this->eventModelFactory->create();
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This event no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        return $this->initAction($model);
    }

    protected function initAction($model)
    {
        $id = $model->getId();
        $title = $model->getTitle();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Blackbird_TicketBlaster::ticketblaster_event');
        $resultPage->addBreadcrumb(__('Events'), __('Events'));
        $resultPage->addBreadcrumb(__('Manage Events'), __('Manage Events'));
        $resultPage->addBreadcrumb(
            $id ? __('Edit Event') : __('New Event'),
            $id ? __('Edit Event') : __('New Event')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('TicketBlaster Events'));
        $resultPage->getConfig()->getTitle()->prepend($title ? $title : __('New Event'));
        return $resultPage;
    }

    public function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Blackbird_TicketBlaster::ticketblaster_event_save');
    }
}
