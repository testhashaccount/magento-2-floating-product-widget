# magento-2-floating-product-widget
This module creates floating product widget in every page of your Magento store. Admin can configure button label, widget title, product type and add to cart option. You can also add additional css to override default widget style.

# Types of products

* [Sale Products](#sale-products)
* [Latest Products](#latest-products)
* [Most Viewed Products](#most-viewed-products)
* [Best seller Products](#best-seller-products)

## Sale Products
It shows the first five products which have set "Special Price" and "Special Price From". It will calculate countdown timer and display in widget.

## Latest Products
It shows the first five of the most recently added products. 

## Most Viewed Products
It shows the first five of the most visiting products.

## Best seller Products
It shows the first five of the top-selling products which is ordered frequently.

# Compatibility
Magento 2.x

# Installation
-Install by Composer :

You can install the module by Composer (If your server supports Composer). Please go to the Magento folder and run the command: composer require hashcrypt/floating-product-widget

-Install by uploading files:

Download the zip file and unzip the plugin. Now create folder app/code/Hashcrypt/FloatingWidget and copy all files which you have downloaded to that folder.
Now run below commands to install module,

php bin/magento setup:upgrade
php bin/magento cache:flush

# Configuration
Go to admin panel > Stores > Configuration > Hashcrypt Technologies > Floating Product Widget
