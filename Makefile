wpd=docker exec -it wordpress /usr/bin/wp --allow-root --path=/mnt/wordpress
composer=docker exec -it wordpress /usr/bin/composer

recreate: teardown compose setup

compose:
	docker-compose build && docker-compose up -d

setup:
	${wpd} core download --locale=ja && \
	${wpd} core config --dbhost=db --dbname=wordpress --dbuser=wordpress --dbpass=wordpress && \
	${wpd} core install \
		--url=http://wp-test \
		--title="Awesome website" \
		--admin_user=admin --admin_password=admin --admin_email=admin@admin.com

vendor:
	${wpd} composer install  -n --prefer-dist

test:
	${composer} run test

teardown:
	docker-compose down -v && rm -rf wordpress