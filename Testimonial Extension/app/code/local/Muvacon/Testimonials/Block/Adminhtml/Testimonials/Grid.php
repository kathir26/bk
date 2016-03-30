<?php 
class Muvacon_Testimonials_Block_Adminhtml_Testimonials_Grid extends Mage_Adminhtml_Block_Widget_Grid {
 
    public function __construct() {
        parent::__construct();
        $this->setId('testimonials_grid');
        $this->setDefaultSort('testimonials_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
 
    protected function _prepareCollection() {
        $collection = Mage::getModel('testimonials/testimonials')->getCollection();
		foreach($collection as $link){
			$link->setTestimonialsLanguage(explode(',',$link->getTestimonialsLanguage()));
		}
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns() {
        $this->addColumn('testimonials_id', array(
            'header' => Mage::helper('muvacon_translate')->__('ID'),
            'align' => 'right',
            'width' => '10px',
            'index' => 'testimonials_id',
        ));
 
        $this->addColumn('testimonials_name', array(
            'header' => Mage::helper('muvacon_translate')->__('Testimonial Name'),
            'align' => 'left',
            'index' => 'testimonials_name',
            'width' => '50px',
        ));
		
		$this->addColumn('testimonials_image', array(
            'header' => Mage::helper('muvacon_translate')->__('Testimonial Image'),
            'width' => '100px',
            'index' => 'testimonials_image',
			'filter'    => false,
			'sortable' => false,
			'frame_callback' => array($this, 'callback_image')
        ));
		
		$this->addColumn('testimonials_color', array(
            'header' => Mage::helper('muvacon_translate')->__('Testimonial Color'),
            'align' => 'left',
			'filter'    => false,
            'index' => 'testimonials_color',
            'width' => '25px',
			'renderer' => 'testimonials/adminhtml_testimonials_renderer_color',
        ));
		
		$this->addColumn('testimonials_content', array(
            'header' => Mage::helper('muvacon_translate')->__('Testimonial Content'),
            'width' => '150px',
            'index' => 'testimonials_content',
			'type'	=> 'wrapline',
			'sortable' => false,
			'frame_callback' => array($this, 'shortText')
        ));
		
		$this->addColumn('testimonials_language', array(
            'header' => Mage::helper('muvacon_translate')->__('Language'),
            'width' => '150px',
            'index' => 'testimonials_language',
			'type'          => 'store',
			'store_all'     => true,
			'store_view'    => true,
			'sortable'      => false,
			'filter'    	=> false,
			'filter_condition_callback' => array($this, '_filterStoreCondition'),
        ));
		
		$this->addColumn('testimonials_position', array(
            'header' => Mage::helper('muvacon_translate')->__('Position'),
            'width' => '20px',
            'index' => 'testimonials_position',
			'sortable' => true
        ));
 
		$this->addColumn('testimonials_status',
			array(
			  'header'  => Mage::helper('muvacon_translate')->__('Status'),
			  'width'   => '60px',
			  'index'   => 'testimonials_status',
			  'type'    => 'options',
			  'options' => array(
					0 => 'Active',
					1 => 'Inactive',
				),
			)
		);
 
        $this->addColumn('testimonials_created_date', array(
            'header' 	=> Mage::helper('muvacon_translate')->__('Created On'),
            'width' 	=> '50px',
            'index' 	=> 'testimonials_created_date',
			'default'   => '--',
			'type'    	=> 'datetime',
        ));
		
		$this->addColumn('Action', array(
            'header' 	=> Mage::helper('muvacon_translate')->__('Action'),
            'width' 	=> '50px',
			'filter'    => false,
			'type'		=> 'action',
			'getter'    => 'getTestimonialsId',
			'actions'   => array(
					array(
                        'caption'   => Mage::helper('muvacon_translate')->__('Edit'),
                        'url'       => array('base'=> 'adminhtml/testimonials/edit'),
                        'field'     => 'id'
                    ),
					array(
                        'caption'   => Mage::helper('muvacon_translate')->__('Delete'),
                        'url'       => array('base'=> 'adminhtml/testimonials/delete'),
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