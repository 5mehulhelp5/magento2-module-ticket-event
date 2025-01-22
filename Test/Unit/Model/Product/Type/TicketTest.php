<?php
namespace Blackbird\TicketBlaster\Test\Unit\Model\Product\Type;

use Blackbird\TicketBlaster\Model\Product\Type\Ticket;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Catalog\Model\Product\Option;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Config;
use Magento\Catalog\Model\Product\Type;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Framework\Filesystem;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Blackbird\TicketBlaster\Model\Product\Type\TicketFactory;
use Blackbird\TicketBlaster\Model\EventFactory;
use Blackbird\TicketBlaster\Model\Event;
use Blackbird\TicketBlaster\Model\ResourceModel\Event\Collection;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

class TicketTest extends TestCase
{
    private EventFactory $eventFactory;

    /** @var Ticket|Product|MockObject */
    private $ticket;

    private $model;

    private $timezone;

    private $eventMock;

    protected function setUp(): void
    {
        $this->ticket = $this->getMockBuilder(Product::class)
            ->setMethods(['getStatus', 'hasData', 'getData'])
            ->disableOriginalConstructor()
            ->getMock();

        $catalogProductOption = $this->createMock(Option::class);
        $eavConfig = $this->createMock(Config::class);
        $catalogProductType = $this->createMock(Type::class);
        $eventManager = $this->createMock(ManagerInterface::class);
        $fileStorageDb = $this->createMock(Database::class);
        $filesystem = $this->createMock(Filesystem::class);
        $coreRegistry = $this->createMock(Registry::class);
        $logger = $this->createMock(LoggerInterface::class);
        $productRepository = $this->createMock(ProductRepositoryInterface::class);

        $this->eventMock = $this->createMock(Event::class);
        $collectionMock = $this->createMock(Collection::class);
        $collectionMock->method('addFieldToFilter')->willReturnSelf();
        $collectionMock->method('getFirstItem')->willReturn($this->eventMock);
        $this->eventMock->method('getCollection')->willReturn($collectionMock);

        $this->eventFactory = $this->createMock(EventFactory::class);
        $this->eventFactory->method('create')->willReturn($this->eventMock);

        $this->timezone = $this->createMock(TimezoneInterface::class);

        $this->model = new Ticket(
            $catalogProductOption,
            $eavConfig,
            $catalogProductType,
            $eventManager,
            $fileStorageDb,
            $filesystem,
            $coreRegistry,
            $logger,
            $productRepository,
            $this->eventFactory,
            $this->timezone
        );
    }

    public function testIsEventSalable(): void
    {
        $this->ticket->method('getStatus')->willReturn(Status::STATUS_ENABLED);

        $this->timezone->expects(self::exactly(2))->method('date')
            ->willReturnOnConsecutiveCalls(new \Datetime(), new \Datetime('tomorrow'));
        $tomorrow = new \DateTime('tomorrow');
        $this->eventMock->method('getEventTime')->willReturn($tomorrow->format('Y-m-d H:i:s'));

        $this->assertTrue($this->model->isSalable($this->ticket));
    }

    public function testIsEventNotSalable(): void
    {
        $this->ticket->method('getStatus')->willReturn(Status::STATUS_DISABLED);

        $this->assertFalse($this->model->isSalable($this->ticket));
    }

    public function testIsEventOutDated(): void
    {
        $this->ticket->method('getStatus')->willReturn(Status::STATUS_ENABLED);

        $this->timezone->expects(self::exactly(2))->method('date')
            ->willReturnOnConsecutiveCalls(new \Datetime(), new \Datetime('yesterday'));
        $day = new \DateTime('yesterday');
        $this->eventMock->method('getEventTime')->willReturn($day->format('Y-m-d H:i:s'));

        $this->assertFalse($this->model->isSalable($this->ticket));
    }
}
