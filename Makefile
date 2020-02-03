.PHONY: permissions setup setup-deploy healthcheck composer magento-setup \
    flush-redis npm install-magento vendor-sync permissions-deploy \
    local-deploy static-content db-save install media-load permissions

SHELL := /bin/bash

STATIC_CONTENT_DEPLOY_JOBS = 1
STATIC_CONTENT_DEPLOY_ARGS = -f --jobs=$(STATIC_CONTENT_DEPLOY_JOBS)

-include vars.mk

local-deploy:
	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy -f --jobs=4

composer:
	composer install
npm:
	npm install

permissions:
	chmod 777 ./app/etc
	chmod -R 777 ./var
	chmod -R 777 ./pub/media
	chmod -R 777 ./pub/static
	chown -R :www-data .
	chmod u+x bin/magento
	chmod u+x etc/run.sh

permissions-deploy:
	chmod 777 ./app/etc
	chmod -R 777 ./var
	chmod -R 777 ./pub/media
	chmod -R 777 ./pub/static
	chown -R :www-data .
	chmod u+x bin/magento
	chmod u+x etc/run.sh

magento-setup:
	rm -rf var/generation
	rm -rf generated/*
	php bin/magento setup:upgrade -vvv
	php bin/magento setup:di:compile -vvv

magento-deploy:
	rm -rf var/generation
	rm -rf generated/*
	php bin/magento cache:disable
	php bin/magento setup:upgrade
	php bin/magento setup:di:compile
	php bin/magento cache:enable
	php bin/magento setup:static-content:deploy -f --jobs=1
	php bin/magento cache:flush

setup: composer magento-setup permissions healthcheck

setup-deploy: composer magento-deploy permissions-deploy healthcheck

healthcheck:
	cd /var/www/html
	echo ref: `git rev-parse --abbrev-ref HEAD` > pub/_healthcheck
	echo tag: `git tag --points-at HEAD` >> pub/_healthcheck
	echo msg: `git show HEAD --oneline -s` >> pub/_healthcheck
	echo date: `date -R` >> pub/_healthcheck

flush-redis:
	redis-cli -h redis flushall

db-save:
	bash /var/www/html/etc/bin/db-dump-save.sh

install: composer flush-redis permissions install-magento magento-setup healthcheck

install-magento:
	bash /var/www/html/etc/bin/install.sh

vendor-sync:
	rsync -avh --delete /var/www/html/vendor/ /srv/vendor/ --exclude ".htaccess"
