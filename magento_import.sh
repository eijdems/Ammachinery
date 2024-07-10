#!/bin/sh
echo "started<---->";

/usr/bin/php7.4 /home/cloudpanel/htdocs/www.global-equipment.com/bin/magento importdata:products:importproductam;
/usr/bin/php7.4 /home/cloudpanel/htdocs/www.global-equipment.com/bin/magento indexer:reset;
/usr/bin/php7.4 /home/cloudpanel/htdocs/www.global-equipment.com/bin/magento indexer:reindex;

echo "end<---->";
exit 0
