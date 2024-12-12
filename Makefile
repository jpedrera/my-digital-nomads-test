install:
	@echo "Setting up the test project..."
	@rm -rf .env
	@cp .env.example .env
	@php artisan key:generate

	@docker-compose up -d --remove-orphans --force-recreate --build
	@echo "Setting up the database..."
	@sleep 4
	@php artisan migrate --seed

	@echo "Now please run 'php artisan serve' and have fun!"



