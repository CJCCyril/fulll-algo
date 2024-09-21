help: ## Output this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

display-sequence-number: ## Usage: make display-sequence-number number=[number] | Example: make display-sequence-number number=25
	@docker compose run --rm fulll-algo-php php index.php $(number)
