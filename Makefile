all:
	curl -s http://getcomposer.org/installer | php

install:
	php composer.phar install

update:
	php composer.phar update