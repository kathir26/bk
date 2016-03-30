<?php
class Muvacon_CartCount_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("CartCount"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("cartcount", array(
                "label" => $this->__("CartCount"),
                "title" => $this->__("CartCount")
		   ));

      $this->renderLayout(); 
	  
    }
	public function ItemAction() {
	  $this->loadLayout();   
	  $total = Mage::getModel('checkout/cart')->getQuote()->getGrandTotal(); ?>

		<div class="">
  <?php
   $total = Mage::getModel('checkout/cart')->getQuote()->getGrandTotal(); 
   if((integer)$total > 0)
   {
	   $total		= Mage::helper('core')->currency($total, true, false);
  ?>
<?php
      $cart = Mage::getModel('checkout/cart')->getQuote();
	  $_helper = Mage::helper('catalog/output');
      ?>
    <div class="scroll-cart"><ul role="menu" aria-labelledby="dLabel">
       <?php
       foreach ($cart->getAllItems() as $item) {
        $productName = $item->getProduct()->getName();
        $productPrice = $item->getProduct()->getPrice();
        $productQty = $item->getQty();
        $productUrl = $item->getProduct()->getProductUrl();
       ?>
       <li>
           <a href="<?php echo $productUrl; ?>" class="clearfix">
				<p><img src="<?php echo Mage::helper('catalog/image')->init($item->getProduct(), 'small_image')->resize(100,100);?>" alt="<?php echo $productName;?>" align="left" />
					<p class="mrg-separator"><?php echo $productName; ?><br>
					Anzahl: <strong><?php echo $productQty; ?></strong></p>
				
				</p>
				
				
		   <!-- <span><?php //echo Mage_Catalog_Block_Product::getPriceHtml($item->getProduct(), true); ?></span>-->
			</a>
		</li>
       <?php
       }
       ?>
    </ul></div>
    <span class="total">Total: <?php echo $total; ?></span>
	<div class="button-grp clearfix">
	<button type="button" title="Zur Kasse" class="btn btn-default" onclick="setLocation('<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB); ?>onepage/')">Zur Kasse</button></div>
   <?php
   } else { echo 'Ihr Warenkorb ist noch leer'; } ?>
        </div>
<?php	  
    }
	public function newsletterAction() {
		$news	= $_POST['news'];
		Mage::getSingleton('core/session')->setNewsSubscribe($news);
		echo Mage::getSingleton('core/session')->getNewsSubscribe();
	}
	public function cartCountAction() {
		echo number_format($count = Mage::getModel('checkout/cart/')->getQuote()->getItemsQty()); die();
	}
}