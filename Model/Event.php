<?php

namespace Blackbird\TicketBlaster\Model;

use Blackbird\TicketBlaster\Api\Data\EventInterface;
use Blackbird\TicketBlaster\Model\ResourceModel\Event as EventResource;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

class Event extends AbstractModel implements EventInterface, IdentityInterface
{

    /**
     * Event's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Event cache tag
     */
    const CACHE_TAG = 'ticketblaster_event';

    /**
     * @var string
     */
    protected $_cacheTag = 'ticketblaster_event';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ticketblaster_event';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        private UrlInterface $urlBuilder,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(EventResource::class);
    }

    /**
     * Check if event url key exists
     * return event id if event exists
     *
     * @param string $url_key
     * @return int
     */
    public function checkUrlKey($url_key)
    {
        return $this->_getResource()->checkUrlKey($url_key);
    }

    /**
     * Prepare event's statuses.
     * Available event ticketblaster_event_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::EVENT_ID);
    }

    /**
     * Get URL Key
     *
     * @return string
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get venue
     *
     * @return string|null
     */
    public function getVenue()
    {
        return $this->getData(self::VENUE);
    }

    /**
     * Get event time
     *
     * @return string|null
     */
    public function getEventTime()
    {
        return $this->getData(self::EVENT_TIME);
    }

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive()
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setId($id)
    {
        return $this->setData(self::EVENT_ID, $id);
    }

    /**
     * Set URL Key
     *
     * @param string $url_key
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setUrlKey($url_key)
    {
        return $this->setData(self::URL_KEY, $url_key);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set venue
     *
     * @param string $venue
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setVenue($venue)
    {
        return $this->setData(self::VENUE, $venue);
    }

    /**
     * Set event time
     *
     * @param string $event_time
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setEventTime($event_time)
    {
        return $this->setData(self::EVENT_TIME, $event_time);
    }

    /**
     * Set creation time
     *
     * @param string $creation_time
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setCreationTime($creation_time)
    {
        return $this->setData(self::CREATION_TIME, $creation_time);
    }

    /**
     * Set update time
     *
     * @param string $update_time
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setUpdateTime($update_time)
    {
        return $this->setData(self::UPDATE_TIME, $update_time);
    }

    /**
     * Set is active
     *
     * @param int|bool $is_active
     * @return \Blackbird\TicketBlaster\Api\Data\EventInterface
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }

    /**
     * Return the desired URL of an event
     * @return string
     */
    public function getUrl()
    {
        return $this->urlBuilder->getUrl('events/view/index', ['id' => $this->getId()]);
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }
}
