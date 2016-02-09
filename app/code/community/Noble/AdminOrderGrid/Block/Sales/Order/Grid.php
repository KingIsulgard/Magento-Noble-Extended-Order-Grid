<?php

/**
 * @category     Noble
 * @package      Noble_AdminOrderGrid
 * @author       Gilles Lesire
 *
 * Class Noble_AdminOrderGrid_Block_Sales_Order_Grid
 * This class overrides the default orders grid in the Admin panel
 */
class Noble_AdminOrderGrid_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_grid_collection';
    }

    protected function _prepareCollection()
    {
		$orderFields = array();
		$billingFields = array();
		$shippingFields = array();
		$paymentFields = array();
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_method')) {
			$orderFields["shipping_method"] = "shipping_method";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/customer_email')) {
			$orderFields["customer_email"] = "customer_email";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/amount_items')) {
			$orderFields["total_qty_ordered"] = "ROUND(total_qty_ordered,0)";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/weight')) {
			$orderFields["weight"] = "weight";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/customer_group')) {
			$orderFields["customer_group_id"] = "customer_group_id";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/subtotal')) {
			$orderFields["subtotal"] = "subtotal";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/remote_ip')) {
			$orderFields["remote_ip"] = "remote_ip";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_country')) {
			$billingFields["billing_country"] = "sfoba.country_id";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_region')) {
			$billingFields["billing_region"] = "sfoba.region";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_city')) {
			$billingFields["billing_city"] = "sfoba.city";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_postcode')) {
			$billingFields["billing_postcode"] = "sfoba.postcode";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_country')) {
			$shippingFields["shipping_country"] = "sfosa.country_id";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_region')) {
			$shippingFields["shipping_region"] = "sfosa.region";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_city')) {
			$shippingFields["shipping_city"] = "sfosa.city";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_postcode')) {
			$shippingFields["shipping_postcode"] = "sfosa.postcode";
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/payment_method')) {
			$paymentFields["payment_method"] = "sfop.method";
		}
		
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $collection->getSelect()->join(Mage::getConfig()->getTablePrefix() . 'sales_flat_order as sfo', 'sfo.entity_id=`main_table`.entity_id', $orderFields)
			->join(Mage::getConfig()->getTablePrefix() . 'sales_flat_order_address as sfoba', 'sfoba.parent_id=`main_table`.entity_id and sfoba.address_type = "billing"', $billingFields)
			->join(Mage::getConfig()->getTablePrefix() . 'sales_flat_order_address as sfosa', 'sfosa.parent_id=`main_table`.entity_id and sfosa.address_type = "shipping"', $shippingFields)
			->join(Mage::getConfig()->getTablePrefix() . 'sales_flat_order_payment as sfop', 'sfop.parent_id=`main_table`.entity_id', $paymentFields);
		
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
		
		if(Mage::getStoreConfig('noble/default_columns/real_order_id')) {
			$this->addColumn('real_order_id', array(
				'header'=> Mage::helper('sales')->__('Order #'),
				'width' => '80px',
				'type'  => 'text',
				'index' => 'increment_id',
				'filter_index' => 'main_table.increment_id'
			));
		}
		
		if(Mage::getStoreConfig('noble/default_columns/store_id')) {
			if (!Mage::app()->isSingleStoreMode()) {
				$this->addColumn('store_id', array(
					'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
					'index'     => 'store_id',
					'type'      => 'store',
					'store_view'=> true,
					'display_deleted' => true,
					'filter_index' => 'sfo.store_id'
				));
			}
		}
		
		if(Mage::getStoreConfig('noble/default_columns/created_at')) {
			$this->addColumn('created_at', array(
				'header' => Mage::helper('sales')->__('Purchased On'),
				'index' => 'created_at',
				'type' => 'datetime',
				'width' => '100px',
				'filter_index' => 'main_table.created_at'
			));
		}
		
		if(Mage::getStoreConfig('noble/default_columns/billing_name')) {
			$this->addColumn('billing_name', array(
				'header' => Mage::helper('sales')->__('Bill to Name'),
				'index' => 'billing_name',
				'filter_index' => 'main_table.billing_name'
			));
		}
		
		if(Mage::getStoreConfig('noble/default_columns/shipping_name')) {
			$this->addColumn('shipping_name', array(
				'header' => Mage::helper('sales')->__('Ship to Name'),
				'index' => 'shipping_name',
				'filter_index' => 'main_table.shipping_name'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/amount_items')) {
			$this->addColumn('total_qty_ordered', array(
				'header' => $this->__('# of Items'),
				'type' => 'int',
				'index' => 'total_qty_ordered', 
				'width' => '40px'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/weight')) {
			$this->addColumn('weight', array(
				'header' => $this->__('Weight'),
				'index' => 'weight',
				'filter_index' => 'sfo.weight'
			));
		}

		if(Mage::getStoreConfig('noble/default_columns/base_grand_total')) {
			$this->addColumn('base_grand_total', array(
				'header' => Mage::helper('sales')->__('G.T. (Base)'),
				'index' => 'base_grand_total',
				'type'  => 'currency',
				'currency' => 'base_currency_code',
			));
		}
		
		if(Mage::getStoreConfig('noble/default_columns/grand_total')) {
			$this->addColumn('grand_total', array(
				'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
				'index' => 'grand_total',
				'type'  => 'currency',
				'currency' => 'order_currency_code',
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/subtotal')) {
			$this->addColumn('subtotal', array(
				'header' => Mage::helper('sales')->__('Subtotal'),
				'index' => 'subtotal',
				'type'  => 'currency',
				'currency' => 'order_currency_code',
			));
		}
		
		if(Mage::getStoreConfig('noble/default_columns/status')) {
			$this->addColumn('status', array(
				'header' => $this->__('Status'),
				'index' => 'status',
				'type' => 'options',
				'width' => '70px',
				'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
				'filter_index' => 'main_table.status'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/customer_group')) {
			$this->addColumn('customer_group_id', array(
				'header'    =>  Mage::helper('customer')->__('Customer Group'),
				'width'     =>  '100',
				'index'     =>  'customer_group_id',
				'type'      =>  'options',
				'options'   =>  $this->getCustomerGroupOptions(),
				'renderer' => 'Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_CustomerGroup'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_method')) {
			$this->addColumn('shipping_method', array(
				'header' => $this->__('Shipping method'),
				'index' => 'shipping_method',
				'filter_index' => 'sfo.shipping_method', 
				'type' => 'options',
				'options' => $this->getShippingMethodOptions(),
				'renderer' => 'Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_Shippingmethod'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/customer_email')) {
			$this->addColumn('customer_email', array(
				'header' => $this->__('Customer email'),
				'index' => 'customer_email'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_country') == "code") {
			$this->addColumn('billing_country', array(
				'header' => Mage::helper('sales')->__('Billing Country'), 
				'index' => 'billing_country', 
				'filter_index' => 'sfoba.country_id', 
				'width' => '60'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_country') == "full") {
			$this->addColumn('billing_country', array(
				'header'   => Mage::helper('sales')->__('Billing Country'), 
				'index'    => 'billing_country',
				'type' => 'options',
				'options' => $this->getCountryOptions(),
				'filter_index' => 'sfoba.country_id', 
				'renderer' => 'adminhtml/widget_grid_column_renderer_country',
				'width' => '60'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_region')) {
			$this->addColumn('billing_region', array(
				'header' => $this->__('Billing Region'),
				'index' => 'billing_region', 
				'filter_index' => 'sfoba.region'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_city')) {
			$this->addColumn('billing_city', array(
				'header' => $this->__('Billing City'),
				'index' => 'billing_city',
				'filter_index' => 'sfoba.city'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/billing_postcode')) {
			$this->addColumn('billing_postcode', array(
				'header' => $this->__('Billing Postcode'),
				'index' => 'billing_postcode',
				'filter_index' => 'sfoba.postcode'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_country') == "code") {
			$this->addColumn('shipping_country', array(
				'header' => Mage::helper('sales')->__('Billing Country'), 
				'index' => 'shipping_country', 
				'filter_index' => 'sfosa.country_id', 
				'width' => '60'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_region')) {
			$this->addColumn('shipping_region', array(
				'header' => $this->__('Shipping Region'),
				'index' => 'shipping_region',
				'filter_index' => 'sfosa.region'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_city')) {
			$this->addColumn('shipping_city', array(
				'header' => $this->__('Shipping City'),
				'index' => 'shipping_city',
				'filter_index' => 'sfosa.city'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_postcode')) {
			$this->addColumn('shipping_postcode', array(
				'header' => $this->__('Shipping Postcode'),
				'index' => 'shipping_postcode',
				'filter_index' => 'sfosa.postcode'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/shipping_country') == "full") {
			$this->addColumn('billing_country', array(
				'header'   => Mage::helper('sales')->__('Billing Country'), 
				'index'    => 'shipping_country',
				'type' => 'options',
				'options' => $this->getCountryOptions(),
				'filter_index' => 'sfosa.country_id', 
				'renderer' => 'adminhtml/widget_grid_column_renderer_country',
				'width' => '60'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/payment_method')) {
			$this->addColumn('payment_method', array(
				'header' => Mage::helper('sales')->__('Payment method'), 
				'index' => 'payment_method',
				'filter_index' => 'sfop.method', 
				'type' => 'options',
				'options' => $this->getPaymentMethodOptions(),
				'renderer' => 'Noble_AdminOrderGrid_Block_Sales_Order_Grid_Renderer_Paymentmethod',
				'width' => '60'
			));
		}
		
		if(Mage::getStoreConfig('noble/extended_columns/remote_ip')) {
			$this->addColumn('remote_ip', array(
				'header' => $this->__('Remote IP'),
				'index' => 'remote_ip',
				'filter_index' => 'sfo.remote_ip'
			));
		}
		
		if(Mage::getStoreConfig('noble/default_columns/action')) {
			if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
				$this->addColumn('action',
					array(
						'header'    => Mage::helper('sales')->__('Action'),
						'width'     => '50px',
						'type'      => 'action',
						'getter'     => 'getId',
						'actions'   => array(
							array(
								'caption' => Mage::helper('sales')->__('View'),
								'url'     => array('base'=>'*/sales_order/view'),
								'field'   => 'order_id'
							)
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));
			}
		}
		
        $this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('order_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/cancel')) {
            $this->getMassactionBlock()->addItem('cancel_order', array(
                 'label'=> Mage::helper('sales')->__('Cancel'),
                 'url'  => $this->getUrl('*/sales_order/massCancel'),
            ));
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/hold')) {
            $this->getMassactionBlock()->addItem('hold_order', array(
                 'label'=> Mage::helper('sales')->__('Hold'),
                 'url'  => $this->getUrl('*/sales_order/massHold'),
            ));
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/unhold')) {
            $this->getMassactionBlock()->addItem('unhold_order', array(
                 'label'=> Mage::helper('sales')->__('Unhold'),
                 'url'  => $this->getUrl('*/sales_order/massUnhold'),
            ));
        }

        $this->getMassactionBlock()->addItem('pdfinvoices_order', array(
             'label'=> Mage::helper('sales')->__('Print Invoices'),
             'url'  => $this->getUrl('*/sales_order/pdfinvoices'),
        ));

        $this->getMassactionBlock()->addItem('pdfshipments_order', array(
             'label'=> Mage::helper('sales')->__('Print Packingslips'),
             'url'  => $this->getUrl('*/sales_order/pdfshipments'),
        ));

        $this->getMassactionBlock()->addItem('pdfcreditmemos_order', array(
             'label'=> Mage::helper('sales')->__('Print Credit Memos'),
             'url'  => $this->getUrl('*/sales_order/pdfcreditmemos'),
        ));

        $this->getMassactionBlock()->addItem('pdfdocs_order', array(
             'label'=> Mage::helper('sales')->__('Print All'),
             'url'  => $this->getUrl('*/sales_order/pdfdocs'),
        ));

        $this->getMassactionBlock()->addItem('print_shipping_label', array(
             'label'=> Mage::helper('sales')->__('Print Shipping Labels'),
             'url'  => $this->getUrl('*/sales_order_shipment/massPrintShippingLabel'),
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        }
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
	
	/**
     * Returns possible filters for CustomerGroup column.
     *
     * @return array
     */
    public function getCustomerGroupOptions()
    {
        $options = Mage::getResourceModel('customer/group_collection')
            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
            ->load()
            ->toOptionHash();
			
        return $options;
    }
	
    /**
     * Returns possible filters for ShippingMethod column.
     *
     * @return array
     */
    public function getShippingMethodOptions()
    {
        $options = array();
        $optionText = "";
        $collection = Mage::getModel('sales/order')->getCollection()->addFieldToSelect('shipping_method');
        $collection->getSelect()->group('shipping_method');
        foreach ($collection as $option) {
			$optionText = "";
			
            if ($option->getShippingMethod() == "dpdparcelshops_dpdparcelshops") {
                $optionText = 'DPD parcelshop';
            } elseif ($option->getShippingMethod() == "dpdclassic_dpdclassic") {
                $optionText = 'DPD classic';
            } elseif ($option->getShippingMethod() == "freeshipping_freeshipping") {
                $optionText = 'Afhalen bureau';
            } elseif ($option->getShippingMethod() == "ups_03") {
                $optionText = 'UPS Ground';
            }
			
			if($optionText) {
            	$options[$option->getShippingMethod()] = $optionText;
			}
        }
        return $options;
    }
	
    /**
     * Returns possible filters for PaymentMethod column.
     *
     * @return array
     */
    public function getPaymentMethodOptions()
    {
        $options = array();
        $optionText = "";
        $collection = Mage::getModel('sales/order_payment')->getCollection()->addFieldToSelect('method');
        $collection->getSelect()->group('method');
        foreach ($collection as $option) {
			$optionText = "";
			
            if ($option->getMethod() == "msp_banktransfer") {
                $optionText = 'MSP Banktransfer';
            } elseif ($option->getMethod() == "msp_directdebit") {
                $optionText = 'MSP Direct Debit';
            } elseif ($option->getMethod() == "msp_directebanking") {
                $optionText = 'MSP Direct Banking';
            } elseif ($option->getMethod() == "msp_giropay") {
                $optionText = 'MSP Giropay';
            } elseif ($option->getMethod() == "msp_ideal") {
                $optionText = 'MSP Ideal';
            } elseif ($option->getMethod() == "msp_maestro") {
                $optionText = 'MSP Maestro';
            } elseif ($option->getMethod() == "msp_mastercard") {
                $optionText = 'MSP Mastercard';
            } elseif ($option->getMethod() == "msp_mistercash") {
                $optionText = 'MSP Mister Cash';
            } elseif ($option->getMethod() == "msp_paypal") {
                $optionText = 'MSP Paypal';
            } elseif ($option->getMethod() == "msp_visa") {
                $optionText = 'MSP Visa';
            } elseif ($option->getMethod() == "paypal") {
                $optionText = 'PayPal';
			} elseif ($option->getMethod() == "ugiftcert") {
				$optionText = 'Unirgy Gift Certificate';
            } else {
                $optionText = ucfirst($option->getMethod());
            }
			
			if($optionText) {
            	$options[$option->getMethod()] = ucfirst($optionText);
			}
        }
        return $options;
    }
	
    /**
     * Returns possible filters for Country column.
     *
     * @return array
     */
    public function getCountryOptions()
    {
       	$options = Mage::getResourceModel('directory/country_collection')->load()->toOptionArray(); 
        $countries = array(); 
        foreach($options as $options){
             $countries[$options['value']]=$options['label']; 
            } 
    	return $countries;
    }
}