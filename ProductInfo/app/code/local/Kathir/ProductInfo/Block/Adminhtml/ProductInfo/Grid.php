<?php 
class Kathir_ProductInfo_Block_Adminhtml_ProductInfo_Grid extends Mage_Adminhtml_Block_Widget_Grid {
 
    public function __construct() {
        parent::__construct();
        $this->setId('productInfo_grid');
        $this->setDefaultSort('productInfo_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
 
    protected function _prepareCollection() {
        $collection = Mage::getModel('productInfo/productInfo')->getCollection();
		foreach($collection as $link){
			$link->setLanguage(explode(',',$link->getLanguage()));
		}
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns() {
        $this->addColumn('productInfo_id', array(
            'header' => Mage::helper('kathir_productInfo')->__('ID'),
            'align' => 'right',
            'width' => '10px',
            'index' => 'productInfo_id',
        ));
 
        $this->addColumn('firstname', array(
            'header' => Mage::helper('kathir_productInfo')->__('First Name'),
            'align' => 'left',
            'index' => 'firstname',
            'width' => '50px',
        ));
		
		$this->addColumn('lastname', array(
            'header' => Mage::helper('kathir_productInfo')->__('Last Name'),
            'align' => 'left',
            'index' => 'lastname',
            'width' => '50px',
        ));
		
		$this->addColumn('mobile', array(
            'header' => Mage::helper('kathir_productInfo')->__('Mobile No.'),
            'align' => 'left',
            'index' => 'mobile',
            'width' => '50px',
        ));
		
		$this->addColumn('location', array(
            'header' => Mage::helper('kathir_productInfo')->__('Location'),
            'width' => '150px',
            'index' => 'location',
			'sortable' => true
        ));
 
		$this->addColumn('status',
			array(
			  'header'  => Mage::helper('kathir_productInfo')->__('Status'),
			  'width'   => '60px',
			  'index'   => 'status',
			  'type'    => 'options',
			  'options' => array(
					0 => 'Active',
					1 => 'Inactive',
				),
			)
		);
 
        $this->addColumn('created_date', array(
            'header' 	=> Mage::helper('kathir_productInfo')->__('Created On'),
            'width' 	=> '50px',
            'index' 	=> 'created_date',
			'default'   => '--',
			'type'    	=> 'datetime',
        ));
		
		$this->addColumn('Action', array(
            'header' 	=> Mage::helper('kathir_productInfo')->__('Action'),
            'width' 	=> '50px',
			'filter'    => false,
			'width'     => '100',
			'type'      => 'text',
			'renderer'  => 'Kathir_ProductInfo_Block_Adminhtml_Renderer_Actionlink',
			/*'actions'   => array(
					array(
                        'caption'   => Mage::helper('kathir_productInfo')->__('Edit'),
						'renderer'  => 'Kathir_ProductInfo_Block_Adminhtml_Renderer_Actionlink',
                        'field'     => 'fk_product_id',
						'popup'  	=> true
                    ),
					array(
                        'caption'   => Mage::helper('kathir_productInfo')->__('Delete'),
                        'url'       => array('base'=> 'adminhtml/productInfo/delete'),
                        'field'     => 'productInfo_id',
						'confirm'  => Mage::helper('kathir_productInfo')->__('Are you sure want to delete?')
                    )
                ),*/
			'sortable' => false,
			'index' => 'stores',
			'is_system' => true,
        ));
 
        return parent::_prepareColumns();
    }
	
	public function shortText($string) {
		$length = 120;
		if (strlen($string) <= $length) {
			return $string;
		} else {
			$string = strip_tags($string);
			$string = substr($string, 0, $length) . ' ...';
		}

		return $string;
	}
	
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
		$this->getCollection()->addStoreFilter($value);
	}
	
	public function callback_image($value)
	{
		$width = 147;
		$height = 51;
		return "<img src='".Mage::getBaseUrl('media').$value."' width=".$width." height=".$height."/>";
	}
}