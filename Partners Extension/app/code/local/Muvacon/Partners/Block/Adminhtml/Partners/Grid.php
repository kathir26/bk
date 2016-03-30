<?php 
class Muvacon_Partners_Block_Adminhtml_Partners_Grid extends Mage_Adminhtml_Block_Widget_Grid {
 
    public function __construct() {
        parent::__construct();
        $this->setId('partners_grid');
        $this->setDefaultSort('partners_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
 
    protected function _prepareCollection() {
        $collection = Mage::getModel('partners/partners')->getCollection();
		foreach($collection as $link){
			$link->setCompanyLanguage(explode(',',$link->getCompanyLanguage()));
		}
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns() {
        $this->addColumn('partners_id', array(
            'header' => Mage::helper('muvacon_partners')->__('ID'),
            'align' => 'right',
            'width' => '10px',
            'index' => 'partners_id',
        ));
 
        $this->addColumn('company_name', array(
            'header' => Mage::helper('muvacon_partners')->__('Comapny Name'),
            'align' => 'left',
            'index' => 'company_name',
            'width' => '50px',
        ));
		
        $this->addColumn('company_logo', array(
            'header' => Mage::helper('muvacon_partners')->__('Company Logo'),
            'width' => '150px',
            'index' => 'company_logo',
			'filter'    => false,
			'sortable' => false,
			'frame_callback' => array($this, 'callback_image')
        ));
		
		$this->addColumn('company_description', array(
            'header' => Mage::helper('muvacon_partners')->__('Company Description'),
            'width' => '150px',
            'index' => 'company_description',
			'type'	=> 'wrapline',
			'sortable' => false,
			'frame_callback' => array($this, 'shortText')
        ));
		
		$this->addColumn('company_language', array(
            'header' => Mage::helper('muvacon_partners')->__('Language'),
            'width' => '150px',
            'index' => 'company_language',
			'type'          => 'store',
			'store_all'     => true,
			'store_view'    => true,
			'sortable'      => false,
			'filter'    	=> false,
			'filter_condition_callback' => array($this, '_filterStoreCondition'),
        ));
		
		$this->addColumn('company_position', array(
            'header' => Mage::helper('muvacon_partners')->__('Position'),
            'width' => '150px',
            'index' => 'company_position',
			'sortable' => true
        ));
 
		$this->addColumn('company_status',
			array(
			  'header'  => Mage::helper('muvacon_partners')->__('Status'),
			  'width'   => '60px',
			  'index'   => 'company_status',
			  'type'    => 'options',
			  'options' => array(
					0 => 'Active',
					1 => 'Inactive',
				),
			)
		);
 
        $this->addColumn('company_created_date', array(
            'header' 	=> Mage::helper('muvacon_partners')->__('Created On'),
            'width' 	=> '50px',
            'index' 	=> 'company_created_date',
			'default'   => '--',
			'type'    	=> 'datetime',
        ));
		
		$this->addColumn('Action', array(
            'header' 	=> Mage::helper('muvacon_partners')->__('Action'),
            'width' 	=> '50px',
			'filter'    => false,
			'type'		=> 'action',
			'getter'    => 'getPartnersId',
			'actions'   => array(
					array(
                        'caption'   => Mage::helper('muvacon_partners')->__('Edit'),
                        'url'       => array('base'=> 'adminhtml/partners/edit'),
                        'field'     => 'id'
                    ),
					array(
                        'caption'   => Mage::helper('muvacon_partners')->__('Delete'),
                        'url'       => array('base'=> 'adminhtml/partners/delete'),
                        'field'     => 'id',
						'confirm'  => Mage::helper('muvacon_partners')->__('Are you sure want to delete?')
                    )
                ),
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
	
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}