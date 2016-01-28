<?php
/**
 * @category     Noble
 * @package      Noble_AdminOrderGrid
 * @author       Gilles Lesire
 *
 * Class Noblee_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_Shippingmethod
 * This class defines the different shipping methods available to filter on in the grid
 */
class Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_Shippingmethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders select between shipping methods.
     *
     * @param Varien_Object $row
     * @return string 
     */
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        if ($value == "dpdparcelshops_dpdparcelshops") {
            return 'DPD parcelshop';
        } elseif ($value == "dpdclassic_dpdclassic") {
            return 'DPD classic';
        } elseif ($value == "freeshipping_freeshipping") {
            return 'Afhalen bureau';
        } elseif ($value == "ups_03") {
            return 'UPS Ground';
        }
			
        return $value;
    }
}