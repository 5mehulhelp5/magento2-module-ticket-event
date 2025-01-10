<?php
namespace Blackbird\TicketBlaster\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Product;

class ApplyTicketAttributes implements DataPatchInterface
{
    public function __construct(
        private EavSetupFactory $eavSetupFactory
    ) {}

    public function apply()
    {
        $fieldList = [
            'price',
            'special_price',
            'special_from_date',
            'special_to_date',
            'minimal_price',
            'cost',
            'tier_price',
            'group_price',
            'tax_class_id'
        ];

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();
        foreach ($fieldList as $field) {
            $attributeData = $eavSetup->getAttribute(Product::ENTITY, $field, 'apply_to');
            if (!$attributeData) {
                continue;
            }

            $applyTo = explode(',', $attributeData);
            if (!in_array('ticket', $applyTo)) {
                $applyTo[] = 'ticket';
                $eavSetup->updateAttribute(Product::ENTITY, $field, 'apply_to', implode(',', $applyTo));
            }
        }
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
