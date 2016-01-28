<?php
/**
 * @category     Noble
 * @package      Noble_AdminOrderGrid
 * @author       Gilles Lesire
 *
 * Class Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_Paymentmethod
 * This class defines the different payment methods available to filter on in the grid
 */
class Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_Paymentmethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders select between payment methods.
     *
     * @param Varien_Object $row
     * @return string 
     */
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
		
		if ($value == "msp_banktransfer") {
			return 'MSP Banktransfer';
		} elseif ($value == "msp_directdebit") {
			return 'MSP Direct Debit';
		} elseif ($value == "msp_directebanking") {
			return 'MSP Direct Banking';
		} elseif ($value == "msp_giropay") {
			return 'MSP Giropay';
		} elseif ($value == "msp_ideal") {
			return 'MSP Ideal';
		} elseif ($value == "msp_maestro") {
			return 'MSP Maestro';
		} elseif ($value == "msp_mastercard") {
			return 'MSP Mastercard';
		} elseif ($value == "msp_mistercash") {
			return 'MSP Mister Cash';
		} elseif ($value == "msp_paypal") {
			return 'MSP Paypal';
		} elseif ($value == "msp_visa") {
			return 'MSP Visa';
		} elseif ($value == "paypal") {
			return 'PayPal';
		}
			
        return ucfirst($value);
    }
}