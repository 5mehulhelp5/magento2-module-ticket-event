<?php
namespace Blackbird\TicketBlaster\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Blackbird\TicketBlaster\Model\Event;
use Blackbird\TicketBlaster\Model\ResourceModel\Event as EventResource;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class EventTest extends TestCase
{
    private Event $testObject;

    /** @var Context|MockObject  */
    private $context;

    /** @var Registry|MockObject */
    private $registry;

    private $urlInterface;

    private $eventResource;

    protected function setUp(): void
    {
        $this->context = $this->createMock(Context::class);
        $this->registry = $this->createMock(Registry::class);
        $this->urlInterface = $this->createMock(UrlInterface::class);
        $this->eventResource = $this->createMock(EventResource::class);
        $this->eventResource->method('getIdFieldName')->willReturn('event_id');

        $this->testObject = new Event(
            $this->context,
            $this->registry,
            $this->urlInterface,
            $this->eventResource
        );
    }

    public function testGetUrl(): void
    {
        $this->urlInterface->expects($this->once())->method('getUrl')->willReturn('url');

        $this->assertEquals('url', $this->testObject->getUrl());
    }
}
