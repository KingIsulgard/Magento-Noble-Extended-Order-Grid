<?php
/**
 * @category     Noble
 * @package      Noble_AdminOrderGrid
 * @author       Gilles Lesire
 *
 * Class Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_CustomerGroup
 * This class defines the different customer groups available to filter on in the grid
 */
class Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_CustomerGroup extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders select between different customer groups.
     *
     * @param Varien_Object $row
     * @return string 
     */
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
		$group = Mage::getModel('customer/group')->load($value);
		return $group->getCode();
    }
}