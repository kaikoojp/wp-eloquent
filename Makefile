# 環境変数
WORDPRESS_VERSION ?= 5.0

# Dockerコマンドエイリアス
wpd=docker exec -it wordpress /usr/bin/wp --allow-root --path=/mnt/wordpress
composer=docker exec -it wordpress /usr/bin/composer


recreate: teardown compose echo setup

compose:
	docker-compose build && docker-compose up -d

setup:
	${wpd} core download --locale=ja --version=${WORDPRESS_VERSION} && \
	${wpd} core config --dbhost=${WORDPRESS_DB_HOST} --dbname=${WORDPRESS_DB_NAME} --dbuser=${WORDPRESS_DB_USER} --dbpass=${WORDPRESS_DB_PASSWORD} && \
	${wpd} core install \
		--url=http://wp-test \
		--title="Awesome website" \
		--admin_user=admin --admin_password=admin --admin_email=admin@admin.com

vendor:
	${composer} install  -n --prefer-dist

test:
	${composer} run test

teardown:
	docker-compose down -v && rm -rf wordpress