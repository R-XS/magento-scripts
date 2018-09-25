<?php
require_once("app/Mage.php");
Mage::app();
Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);

// Only for urls // Don't remove this
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);
Mage::app('admin')->setUseSessionInUrl(false);
Mage::setIsDeveloperMode(true); ini_set('display_errors', 1); error_reporting(E_ALL);
try {
    Mage::getConfig()->init();
    Mage::app();   
} catch (Exception $e) {
    Mage::printException($e);
}
ini_set('memory_limit','500M');
$customerCount = 0;

$orders = Mage::getModel('sales/order')->getCollection();
$orders->setPage(1, 3000);
$fp = fopen('file.csv', 'w');
foreach($orders as $order) {
    $fields = array($order->getBillingAddress()->getFirstname(),$order->getBillingAddress()->getLastname(),$order->getBillingAddress()->getCompany(),$order->getBillingAddress()->getStreet(1),$order->getBillingAddress()->getStreet(2),$order->getBillingAddress()->getCity(),$order->getBillingAddress()->getRegion(),$order->getBillingAddress()->getPostcode(),$order->getBillingAddress()->getCountry_id(),$order->getBillingAddress()->getEmail(),$order->getBillingAddress()->getTelephone());
    fputcsv($fp, $fields);
}
?>