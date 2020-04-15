# activemq.ocmod
Opencart ActiveMq Extension. Send Opencart Orders to ActiveMQ queue as a messages.

https://www.opencart.com/index.php?route=marketplace/extension/info&extension_id=38845

This extension requires PHP configuration of Opencart server.
PHP STOMP should be installed.
https://www.php.net/manual/en/book.stomp.php

pecl install stomp
echo extension=stomp.so > /usr/local/etc/php/conf.d/stomp.ini

Extension adds listener to "catalog/model/checkout/order/addOrderHistory/before" event.
And fires every time when Opencart sends Email to Customer.

Message data includes all OrderData in JSON format.
