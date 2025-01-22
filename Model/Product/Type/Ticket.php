<?php
namespace Blackbird\TicketBlaster\Model\Product\Type;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Type\Virtual;
use Magento\Framework\File\UploaderFactory;
use Blackbird\TicketBlaster\Model\EventFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Ticket extends Virtual
{
    public const TYPE_CODE = 'ticket';

    public function __construct(
        \Magento\Catalog\Model\Product\Option $catalogProductOption,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\Product\Type $catalogProductType,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageDb,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Registry $coreRegistry,
        \Psr\Log\LoggerInterface $logger,
        ProductRepositoryInterface $productRepository,
        private EventFactory $eventFactory,
        private TimezoneInterface $timezone,
        \Magento\Framework\Serialize\Serializer\Json $serializer = null,
        UploaderFactory $uploaderFactory = null
    ) {
        parent::__construct($catalogProductOption, $eavConfig, $catalogProductType, $eventManager, $fileStorageDb,
            $filesystem, $coreRegistry, $logger, $productRepository, $serializer, $uploaderFactory);
    }


    public function isSalable($product): bool
    {
        $isSalable = parent::isSalable($product);
        return ($isSalable && $this->isEventSalable($product->getData('event_link')));
    }

    private function isEventSalable($eventLink): bool
    {
        $event = $this->eventFactory->create()
            ->getCollection()?->addFieldToFilter('event_id', $eventLink)?->getFirstItem();

        if (!$event->getEventTime()) {
            return false;
        }

        $todayDateTime = $this->timezone->date();
        $eventDate = $this->timezone->date(strtotime($event->getEventTime()));

        return $todayDateTime < $eventDate;
    }
}
