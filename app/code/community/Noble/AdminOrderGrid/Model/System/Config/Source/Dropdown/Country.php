<?php

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