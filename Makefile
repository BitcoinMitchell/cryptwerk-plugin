# --- Variables ---
MODULE          := cryptwerk
MODULE_FOLDER   := ./modules
MODULE_PATH     := $(MODULE_FOLDER)/$(MODULE)

BUILD_FOLDER    := ./build
ZIP_NAME        := $(MODULE).zip
MODULE_OUT      := $(BUILD_FOLDER)/$(ZIP_NAME)

# --- Colors ---
BLUE := \033[36m
RESET := \033[0m

# --- Targets ---
.PHONY: all deps install build bump update upgrade clean lint lint-fix \
	dev-up dev-down dev-logs dev-tunnel dev-reset help

all: build

deps: ## Install and prepare all dependencies
	@echo "$(BLUE)==> Installing dependencies...$(RESET)"
	@cd "$(MODULE_PATH)" && symfony composer install
	@echo "$(BLUE)==> Dumping autoloader...$(RESET)"
	@cd "$(MODULE_PATH)" && symfony composer dump-autoload -o --no-dev

install: ## Install root and module Composer dependencies
	@echo "$(BLUE)==> Installing root dependencies...$(RESET)"
	@symfony composer install
	@echo "$(BLUE)==> Installing module dependencies...$(RESET)"
	@cd "$(MODULE_PATH)" && symfony composer install

build: deps ## Build the module and create ZIP
	@echo "$(BLUE)==> Building module...$(RESET)"
	@rm -f "$(MODULE_OUT)"
	@mkdir -p "$(BUILD_FOLDER)"
	@cp ./LICENSE "$(MODULE_PATH)"
	@cp ./README.md "$(MODULE_PATH)"
	@cd "$(MODULE_FOLDER)" && zip -r "$(ZIP_NAME)" "$(MODULE)" && mv "$(ZIP_NAME)" "../$(BUILD_FOLDER)"
	@echo "$(BLUE)==> Build complete: $(MODULE_OUT)$(RESET)"

bump: ## Bump all PHP dependencies
	@echo "$(BLUE)==> Bumping root dependencies...$(RESET)"
	@symfony composer bump
	@echo "$(BLUE)==> Bumping module dependencies...$(RESET)"
	@cd "$(MODULE_PATH)" && symfony composer bump

update: ## Update all dependencies (including dev)
	@echo "$(BLUE)==> Updating root dependencies...$(RESET)"
	@symfony composer update
	@echo "$(BLUE)==> Updating module dependencies...$(RESET)"
	@cd "$(MODULE_PATH)" && symfony composer update

upgrade: ## Upgrade all dependencies (including dev, with constraints)
	@echo "$(BLUE)==> Upgrading root dependencies...$(RESET)"
	@symfony composer upgrade -W
	@echo "$(BLUE)==> Upgrading module dependencies...$(RESET)"
	@cd "$(MODULE_PATH)" && symfony composer upgrade -W

clean: ## Remove previous builds and vendor files
	@echo "$(BLUE)==> Cleaning build artifacts...$(RESET)"
	@rm -f "$(MODULE_OUT)"
	@rm -rf "$(MODULE_PATH)/vendor"
	@find "$(MODULE_FOLDER)" -mindepth 1 -maxdepth 1 -type d ! -name "$(MODULE)" -exec rm -rf {} +

lint: ## Run linter (dry-run mode)
	@echo "$(BLUE)==> Running PHP CS Fixer (dry-run)...$(RESET)"
	@symfony php ./vendor/bin/php-cs-fixer fix --diff --dry-run -v
	@echo "$(BLUE)==> Running PHPCS...$(RESET)"
	@symfony php ./vendor/bin/phpcs -p

lint-fix: ## Auto-fix linter issues
	@echo "$(BLUE)==> Fixing code style with PHP CS Fixer...$(RESET)"
	@symfony php ./vendor/bin/php-cs-fixer fix -v
	@echo "$(BLUE)==> Running PHPCBF...$(RESET)"
	@symfony php ./vendor/bin/phpcbf -p

dev-up: install ## Start the local Docker stack (PrestaShop + Mailpit)
	@cd development && docker compose up -d

dev-down: ## Stop the local Docker stack
	@cd development && docker compose --profile tunnel down

dev-logs: ## Follow Docker logs
	@cd development && docker compose logs -f

dev-tunnel: ## Start stack with ngrok tunnel
	@cd development && docker compose -f docker-compose.yml -f docker-compose.tunnel.yml --profile tunnel up -d --force-recreate prestashop ngrok
	@echo "* Waiting for ngrok tunnel..."
	@i=0; while [ $$i -lt 45 ]; do \
		curl -sf http://127.0.0.1:4040/api/tunnels >/dev/null 2>&1 && break; \
		i=$$((i+1)); sleep 1; \
	done
	@echo "* PrestaShop: $$(curl -sf http://127.0.0.1:4040/api/tunnels | python3 -c 'import json,sys; t=json.load(sys.stdin)["tunnels"]; print(next((x["public_url"] for x in t if x.get("proto")=="https"), t[0]["public_url"] if t else "(unavailable)"))')"
	@echo "* Inspector:  http://localhost:4040"

dev-reset: dev-down ## Wipe volumes and restart fresh
	@cd development && docker compose --profile tunnel down -v
	@$(MAKE) dev-up

help: ## Show this help message
	@echo "$(BLUE)Available targets:$(RESET)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) \
		| sort \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "  $(BLUE)%-15s$(RESET) %s\n", $$1, $$2}'
