PORT ?= 8080

start:
	php -S 0.0.0.0:$(PORT) -t public public/index.php

compose:
	docker-compose up