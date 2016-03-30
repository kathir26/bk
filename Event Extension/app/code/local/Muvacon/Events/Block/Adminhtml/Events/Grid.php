<?php 
class Muvacon_Events_Block_Adminhtml_Events_Grid extends Mage_Adminhtml_Block_Widget_Grid {
 
    public function __construct() {
        parent::__construct();
        $this->setId('events_grid');
        $this->setDefaultSort('event_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
 
    protected function _prepareCollection() {
        $collection = Mage::getModel('events/events')->getCollection();
		foreach($collection as $link){
			$link->setEventLanguage(explode(',',$link->getEventLanguage()));
		}
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns() {
        $this->addColumn('event_id', array(
            'header' => Mage::helper('muvacon_translate')->__('ID'),
            'align' => 'right',
            'width' => '10px',
            'index' => 'event_id',
        ));
 
        $this->addColumn('event_name', array(
            'header' => Mage::helper('muvacon_translate')->__('Event Name'),
            'align' => 'left',
            'index' => 'event_name',
            'width' => '50px',
        ));
		
		$this->addColumn('event_image', array(
            'header' => Mage::helper('muvacon_translate')->__('Event Image'),
            'width' => '100px',
            'index' => 'event_image',
			'filter'    => false,
			'sortable' => false,
			'frame_callback' => array($this, 'callback_image')
        ));
		
		$this->addColumn('event_place', array(
            'header' => Mage::helper('muvacon_translate')->__('Event Place'),
            'align' => 'left',
            'index' => 'event_place',
            'width' => '50px',
        ));
		
		$this->addColumn('event_start_date', array(
            'header' => Mage::helper('muvacon_translate')->__('Event Start Date'),
            'align' => 'left',
            'index' => 'event_start_date',
            'width' => '50px',
			'default'   => '--',
			'type'    	=> 'date',
        ));
		
		$this->addColumn('event_end_date', array(
            'header' => Mage::helper('muvacon_translate')->__('Event End Date'),
            'align' => 'left',
            'index' => 'event_end_date',
            'width' => '50px',
			'default'   => '--',
			'type'    	=> 'date',
        ));
		
		$this->addColumn('event_banner', array(
            'header' => Mage::helper('muvacon_translate')->__('Event Banner'),
            'width' => '20px',
            'index' => 'event_banner',
			'type'  => 'options',
			'filter'    	=> false,
			'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
        ));
		
		$this->addColumn('event_description', array(
            'header' => Mage::helper('muvacon_translate')->__('Event Description'),
            'width' => '150px',
            'index' => 'event_description',
			'type'	=> 'wrapline',
			'sortable' => false,
			'frame_callback' => array($this, 'shortText')
        ));
		
		$this->addColumn('event_language', array(
            'header' => Mage::helper('muvacon_translate')->__('Language'),
            'width' => '150px',
            'index' => 'event_language',
			'type'          => 'store',
			'store_all'     => true,
			'store_view'    => true,
			'sortable'      => false,
			'filter'    	=> false,
			'filter_condition_callback' => array($this, '_filterStoreCondition'),
        ));
		
		$this->addColumn('event_position', array(
            'header' => Mage::helper('muvacon_translate')->__('Position'),
            'width' => '20px',
            'index' => 'event_position',
			'sortable' => true
        ));
 
		$this->addColumn('event_status',
			array(
			  'header'  => Mage::helper('muvacon_translate')->__('Status'),
			  'width'   => '60px',
			  'index'   => 'event_status',
			  'type'    => 'options',
			  'options' => array(
					0 => 'Active',
					1 => 'Inactive',
				),
			)
		);
 
        $this->addColumn('event_created_date', array(
            'header' 	=> Mage::helper('muvacon_translate')->__('Created On'),
            'width' 	=> '50px',
            'index' 	=> 'event_created_date',
			'default'   => '--',
			'type'    	=> 'datetime',
        ));
		
		$this->addColumn('Action', array(
            'header' 	=> Mage::helper('muvacon_translate')->__('Action'),
            'width' 	=> '50px',
			'filter'    => false,
			'type'		=> 'action',
			'getter'    => 'getEventId',
			'actions'   => array(
					array(
                        'caption'   => Mage::helper('muvacon_translate')->__('Edit'),
                        'url'       => array('base'=> 'adminhtml/events/edit'),
                        'field'     => 'id'
                    ),
					array(
                        'caption'   => Mage::helper('muvacon_translate')->__('Delete'),
                        'url'       => array('base'=> 'adminhtml/events/delete'),
                        'field'     => 'id',
						'confirm'  => Mage::helper('muvacon_translate')->__('Are you sure want to delete?')
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