MODULE := "cryptwerk"
MODULE_FOLDER := "./modules"

BUILD_FOLDER := "./build"
ZIP_NAME := "${MODULE}.zip"
MODULE_OUT := "${BUILD_FOLDER}/${ZIP_NAME}"

.PHONY: all deps build clean lint lint-fix

all: build

deps: ## Download and make all dependencies
	# Installing all dependencies
	@cd "$(MODULE_FOLDER)/$(MODULE)" \
		&& composer install

	# Dump autoloader
	@cd "$(MODULE_FOLDER)/$(MODULE)" \
		&& composer dump-autoload -o --no-dev

build: deps ## Build the cryptwerk binary file
	# Removing the old ZIP if present
	@rm -f $(MODULE_OUT)

	# Make the build folder
	@mkdir -p $(BUILD_FOLDER)

	# Copy the license to the module
	@cp ./LICENSE "$(MODULE_FOLDER)/$(MODULE)"

	# Copy the README to the module
	@cp ./README.md "$(MODULE_FOLDER)/$(MODULE)"

	# Zip the module
	@cd $(MODULE_FOLDER) \
		&& zip -r $(ZIP_NAME) $(MODULE) \
		&& mv $(ZIP_NAME) "../$(BUILD_FOLDER)"

update: ## Update all dependencies (including development)
	# Upgrading all root dependencies
	@composer update

	# Upgrading all module dependencies
	@cd "$(MODULE_FOLDER)/$(MODULE)" \
		&& composer update

upgrade: ## Upgrade all dependencies (including development)
	# Upgrading all root dependencies
	@composer upgrade -W

	# Upgrading all module dependencies
	@cd "$(MODULE_FOLDER)/$(MODULE)" \
		&& composer upgrade -W

clean: ## Remove previous builds
	# Removing the ZIP
	@rm -f $(MODULE_OUT)

	# Remove the vendor
	@rm -rf "$(MODULE_FOLDER)/$(MODULE)/vendor"

	# Remove all unnecessary modules
	@ls -d $(MODULE_FOLDER)/* | grep -v $(MODULE) | xargs rm -rf

lint: ## Lints the module
  # Running PHP CS Fixer
	@./vendor/bin/php-cs-fixer fix --diff --dry-run -v

	# Running PHPCS
	@./vendor/bin/phpcs -p

lint-fix: ## Resolves linter issues
  # Running PHP CS Fixer
	@./vendor/bin/php-cs-fixer fix -v

	# Running PHPCS
	@./vendor/bin/phpcbf -p

help: ## Display this help screen
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
