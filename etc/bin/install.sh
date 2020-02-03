#!/usr/bin/env bash

php bin/magento setup:install \
  --language en_US \
  --timezone Asia/Seoul \
  --currency USD \
  --db-host mysql \
  --db-name magento \
  --db-user magento \
  --db-password magento \
  --base-url $APP_BASE_SURL \
  --use-rewrites "1" \
  --use-secure "1" \
  --base-url-secure "$APP_BASE_SURL" \
  --backend-frontname "$APP_BASE_ADMIN" \
  --use-secure-admin "1" \
  --admin-firstname Admin \
  --admin-lastname User \
  --admin-email admin@bighead.net \
  --admin-user admin \
  --admin-password password123 \
  --disable-modules=Magento_Amqp
