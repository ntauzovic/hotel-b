# ============================================================
# Makefile - prečice za Docker komande
# Koristi: make <komanda>
# ============================================================

# Podizanje svih kontejnera
up:
	docker compose up -d

# Podizanje sa build-om (kad mijenjаš Dockerfile)
build:
	docker compose up -d --build

# Zaustavljanje svih kontejnera
down:
	docker compose down

# Restart svih kontejnera
restart:
	docker compose restart

# Prikaz logova
logs:
	docker compose logs -f

# Logovi samo za app
logs-app:
	docker compose logs -f app

# Ulaz u app kontejner (bash terminal)
bash:
	docker compose exec app bash

# Laravel artisan komande
artisan:
	docker compose exec app php artisan $(cmd)

# Pokretanje migracija
migrate:
	docker compose exec app php artisan migrate

# Pokretanje migracija sa seedom
migrate-fresh:
	docker compose exec app php artisan migrate:fresh --seed

# Composer install
composer-install:
	docker compose exec app composer install

# Generisanje APP_KEY
key-generate:
	docker compose exec app php artisan key:generate

# Brisanje cache-a
cache-clear:
	docker compose exec app php artisan optimize:clear

# Status kontejnera
ps:
	docker compose ps

# Potpuno brisanje (kontejneri + volumeni = brise bazu!)
nuke:
	docker compose down -v

# Inicijalni setup - pokreni ovo prvi put!
setup:
	cp -n .env.example .env || true
	docker compose up -d --build
	sleep 5
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate --force
	@echo ""
	@echo "✅ Hotel Backend je spreman na http://localhost"

.PHONY: up build down restart logs logs-app bash artisan migrate migrate-fresh composer-install key-generate cache-clear ps nuke setup
