<?php
/**
 * @category     Noble
 * @package      Noble_AdminOrderGrid
 * @author       Gilles Lesire
 *
 * Class Noble_AdminOrderGrid_Model_System_Config_Source_Dropdown_Country
 * This class creates a select type for the Admin configuration panel
 */
class Noble_AdminOrderGrid_Model_System_Config_Source_Dropdown_Country
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => '0',
                'label' => 'No',
            ),
            array(
                'value' => 'code',
                'label' => 'Show Country Code',
            ),
            array(
                'value' => 'full',
                'label' => 'Show Full Country Name',
            ),
        );
    }
}