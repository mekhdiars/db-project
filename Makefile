PORT ?= 8080

start:
	php -S 0.0.0.0:$(PORT) -t public public/index.php

up:
	docker-compose up -d

down:
	docker-compose down