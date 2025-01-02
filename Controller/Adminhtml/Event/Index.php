<?php
namespace Blackbird\TicketBlaster\Controller\Adminhtml\Event;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Blackbird_TicketBlaster::ticketblaster_event';

    public function __construct(
        Context $context,
        private PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Blackbird_TicketBlaster::ticketblaster_event');
        $resultPage->addBreadcrumb(__('Events'), __('Events'));
        $resultPage->addBreadcrumb(__('Manage Events'), __('Manage Events'));
        $resultPage->getConfig()->getTitle()->prepend(__('TicketBlaster Events'));

        return $resultPage;
    }
}
