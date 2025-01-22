<?php
namespace Blackbird\TicketBlaster\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Product;

class CreateEventLinkAttribute implements DataPatchInterface
{
    public function __construct(
        private EavSetupFactory $eavSetupFactory
    ) {}

    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(Product::ENTITY, 'event_link', [
            'type' => 'int',
            'label' => 'Event',
            'input' => 'select',
            'required' => true,
            'visible' => true,
            'source' => 'Blackbird\TicketBlaster\Model\Event\Attribute\Source\Event',
            'user_defined' => true,
            'apply_to' => 'ticket',
            'default' => '0',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'unique' => false,
            'used_in_product_listing' => true
        ]);

        $eavSetup->addAttributeGroup(Product::ENTITY, 'Default', 'TicketBlaster', 2);
        $entityTypeId = $eavSetup->getEntityTypeId(Product::ENTITY);
        $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);
        $attributeGroupId = $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'TicketBlaster');
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, $attributeGroupId, 'event_link', 10);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
