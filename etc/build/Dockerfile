FROM ubuntu:bionic

MAINTAINER Robert Garcia <rgarcia@bighead.net>

#RUN sed -i 's|http://archive.ubuntu.com/ubuntu/|'"http://mirror.bighead.net/ubuntu/"'|' /etc/apt/sources.list

ENV DEBIAN_FRONTEND noninteractive
ENV TERM xterm
ENV PHP_DIR=/etc/php/7.2

RUN \
  apt-get update && \
  apt-get install --yes --force-yes software-properties-common curl apt-transport-https

RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/apache2

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN \
apt-get update && \
apt-get install --yes --force-yes \
  apache2 \
  dnsutils \
  enscript \
  git \
  mailutils \
  libzend-framework-php \
  mariadb-client \
  nano \
  php7.2-redis \
  php7.2-xml \
  php7.2-cli \
  php7.2-fpm \
  php7.2-dev \
  php7.2-bcmath \
  php7.2-bz2 \
  php7.2-curl \
  php7.2-ctype \
  php7.2-dba \
  php7.2-dom \
  php7.2-gd \
  php7.2-gmp \
  php7.2-iconv \
  php7.2-imagick \
  php7.2-imap \
  php7.2-intl \
  php7.2-json \
  php7.2-ldap \
  php7.2-mbstring \
  php7.2-memcache \
  php7.2-memcached \
  php7.2-mysqlnd \
  php7.2-opcache \
  php7.2-readline \
  php7.2-simplexml \
  php7.2-soap \
  php7.2-sqlite3 \
  php7.2-tidy \
  php7.2-xmlrpc \
  php7.2-xdebug \
  php7.2-xsl \
  php7.2-zip \
  python-pip \
  python3-pip \
  pigz \
  pv \
  redis-tools \
  rsync \
  ssmtp \
  sudo \
  supervisor \
  telnet \
  tree \
  wget \
  vim \
  yarn \
  zip

## install newrelic
RUN echo 'deb http://apt.newrelic.com/debian/ newrelic non-free' | tee /etc/apt/sources.list.d/newrelic.list
RUN wget -O- https://download.newrelic.com/548C16BF.gpg | apt-key add -
RUN apt-get -y update && apt-get -y install newrelic-php5
RUN newrelic-install install
RUN rm -rfv $PHP_DIR/cli/conf.d/newrelic.ini
RUN rm -rfv $PHP_DIR/apache2/conf.d/newrelic.ini
RUN sed 's|newrelic.license = ""|newrelic.license = "${NEW_RELIC_LICENSE}"|' -i $PHP_DIR/mods-available/newrelic.ini
RUN sed 's|newrelic.appname = "PHP Application"|newrelic.appname = "${NEW_RELIC_APPNAME}"|' -i $PHP_DIR/mods-available/newrelic.ini
RUN sed 's|;newrelic.browser_monitoring.auto_instrument = true|newrelic.browser_monitoring.auto_instrument = "${NEW_RELIC_AUTO_INSTRUMENT}"|' -i $PHP_DIR/mods-available/newrelic.ini
RUN echo "newrelic.feature_flag = guzzle" >> $PHP_DIR/mods-available/newrelic.ini

RUN apt-get clean && rm -rf /tmp/* /var/tmp/* && rm -rf /var/lib/apt/lists/*

# install latest nodejs
ENV NODE_VERSION=12.14.0
RUN curl https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.xz -o node-v${NODE_VERSION}-linux-x64.tar.xz
RUN tar -xJf node-v${NODE_VERSION}-linux-x64.tar.xz && rm -rf node-v${NODE_VERSION}-linux-x64.tar.xz
RUN cp -r node-v${NODE_VERSION}-linux-x64/bin node-v${NODE_VERSION}-linux-x64/lib node-v${NODE_VERSION}-linux-x64/share /usr
RUN rm -rf node-v${NODE_VERSION}-linux-x64

# install composer
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install magerun
RUN curl -O https://files.magerun.net/n98-magerun2.phar
RUN chmod +x ./n98-magerun2.phar
RUN mv -v ./n98-magerun2.phar /usr/local/bin/n98-magerun2

# install blackfire
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_DIR/mods-available/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

#FPM config
RUN a2enconf php7.2-fpm

#leave debugger & NR off until needed
RUN /usr/sbin/phpdismod newrelic xdebug blackfire
RUN /usr/sbin/phpenmod mcrypt
RUN /usr/sbin/a2enmod expires headers reqtimeout speling rewrite proxy_fcgi setenvif

#install awscli
RUN pip3 install awscli
RUN pip3 install yacron

#RUN ln -sfn /usr/bin/php5.6 /etc/alternatives/php
RUN node -v
RUN php -v
RUN apachectl -V
RUN composer --version

EXPOSE 80 443
