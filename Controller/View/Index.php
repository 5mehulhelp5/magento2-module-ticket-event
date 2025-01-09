<?php
namespace Blackbird\TicketBlaster\Controller\View;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    public function __construct(
        private PageFactory $resultPageFactory
    ) {}

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
