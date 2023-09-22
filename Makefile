# Makefile para gerenciar o ambiente Docker

# Comandos de inicialização e encerramento

run-app:
	docker-compose up -d
	@echo "Aplicação iniciada com sucesso."

kill-app:
	docker-compose down
	@echo "Aplicação encerrada."

# Comandos de acesso aos contêineres

enter-container:
	docker exec -it $c /bin/sh

enter-nginx-container:
	$(MAKE) enter-container c=nginx
	@echo "Acesso ao contêiner Nginx."

enter-php-container:
	$(MAKE) enter-container c=php
	@echo "Acesso ao contêiner PHP."

enter-mysql-container:
	$(MAKE) enter-container c=mysql
	@echo "Acesso ao contêiner MySQL."

# Comandos de banco de dados

flush-db:
	docker exec php /bin/sh -c "php artisan migrate:fresh"
	@echo "Banco de dados reiniciado (sem seed)."

flush-db-with-seeding:
	docker exec php /bin/sh -c "php artisan migrate:fresh --seed"
	@echo "Banco de dados reiniciado e alimentado com dados (com seed)."

# Ajuda

help:
	@echo "Comandos disponíveis:"
	@echo "  make run-app         - Inicia os contêineres Docker"
	@echo "  make kill-app        - Encerra os contêineres Docker"
	@echo "  make enter-nginx-container - Acessa o contêiner Nginx"
	@echo "  make enter-php-container   - Acessa o contêiner PHP"
	@echo "  make enter-mysql-container - Acessa o contêiner MySQL"
	@echo "  make flush-db        - Reinicia o banco de dados (sem seed)"
	@echo "  make flush-db-with-seeding - Reinicia o banco de dados e o alimenta com dados (com seed)"
	@echo "  make help            - Exibe esta mensagem de ajuda"
