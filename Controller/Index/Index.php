<?php
namespace Blackbird\TicketBlaster\Controller\Index;

class Index implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        echo '<h1>Hello</h1>';
        return $this->resultPageFactory->create();
    }
}
