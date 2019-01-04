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
namespace Hashcrypt\FloatingWidget\Model\Config\Source;

class Type implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray(){
        return [
            ['value' => 'sale', 'label' => __('Sale Products')],
            ['value' => 'latest', 'label' => __('Latest Products')],
            ['value' => 'viewed', 'label' => __('Most Viewed Products')],
            ['value' => 'best', 'label' => __('Best seller Products')]
        ];
    }
}