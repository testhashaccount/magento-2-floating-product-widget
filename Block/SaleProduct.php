<?php
/**
 * Hashcrypt Technologies
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Hashcrypt.com license that is
 * available through the world-wide-web at this URL:
 * https://www.hashcrypt.com/license.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Hashcrypt
 * @package     Hashcrypt_FloatingWidget
 * @copyright   Copyright (c) 2018 Hashcrypt Technologies (https://www.hashcrypt.com/)
 * @license     https://www.hashcrypt.com/license.txt
 */

namespace Hashcrypt\FloatingWidget\Block;

class SaleProduct extends \Magento\Catalog\Block\Product\ListProduct
{

    public function widgetCollection()
    {

        $layer = $this->getLayer();
        /* @var $layer \Magento\Catalog\Model\Layer */

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $collection->addAttributeToFilter('visibility',4);

        $helper = $objectManager->get('Hashcrypt\FloatingWidget\Helper\Data');
        $type = $helper->getGeneralConfig("type");
        if($type == 'sale'){
            $collection = $this->getSale($collection);
        }
        if($type == 'latest'){
            $collection = $this->getLatest($collection);
        }
        if($type == 'viewed'){
            $collection = $this->getMostviewed($collection);
        }
        if($type == 'best'){
            $collection = $this->getBestseller($collection);
        }


        $collection->setPageSize(5);
        $collection->setCurPage(1);
        $this->_eventManager->dispatch(
            'catalog_block_product_list_collection',
            ['collection' => $collection]
        );
        $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());
        
        return $collection;
    }
    public function getBestseller($collection){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $report = $objectManager->get('\Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory')->create();
        $ids = $collection->getAllIds();
        $report->addFieldToFilter('product_id', array('in' => $ids))->setPageSize(5)->setCurPage(1);
        $producIds = array();
        foreach ($report as $product) {
            $producIds[] = $product->getProductId();
        }
        $collection->addAttributeToFilter('entity_id', array('in' => $producIds));
        return $collection;
    }

    public function getLatest($collection){
        $collection = $collection->addStoreFilter()
        ->addAttributeToSort('entity_id', 'desc');
        return $collection;
    }

    public function getMostviewed($collection){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $report = $objectManager->get('\Magento\Reports\Model\ResourceModel\Report\Product\Viewed\CollectionFactory')->create();
        $ids = $collection->getAllIds();
        $report->addFieldToFilter('product_id', array('in' => $ids))->setPageSize(5)->setCurPage(1);
        $producIds = array();
        foreach ($report as $product) {
            $producIds[] = $product->getProductId();
        }
        $collection->addAttributeToFilter('entity_id', array('in' => $producIds));
        return $collection;
    }
    public function getSale($collection){
        $now = date('Y-m-d H:i:s');
        $todayStartOfDayDate = $this->_localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $todayEndOfDayDate = $this->_localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $collection = $collection->addStoreFilter()->addAttributeToFilter(
            'special_from_date',
            [
                'or' => [
                    0 => ['date' => true, 'to' => $todayEndOfDayDate],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        )->addAttributeToFilter(
            'special_to_date',
            [
                'or' => [
                    0 => ['date' => true, 'from' => strtotime($now)],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        )->addAttributeToFilter(
            [
                ['attribute' => 'special_from_date', 'is' => new \Zend_Db_Expr('not null')],
                ['attribute' => 'special_to_date', 'is' => new \Zend_Db_Expr('not null')],
            ]
        )->addAttributeToSort('special_to_date', 'desc');

        return $collection;

    }

}
