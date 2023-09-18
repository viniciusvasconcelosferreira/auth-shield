# Sistema de Autenticação e Autorização

Este é um projeto de Sistema de Autenticação e Autorização desenvolvido utilizando Laravel, PHP 8.2, MySQL e Nginx. O projeto utiliza Docker para facilitar a configuração do ambiente de desenvolvimento.

## Tecnologias Utilizadas

- [Docker](https://www.docker.com/)
- [Laravel](https://laravel.com/)
- PHP 8.2
- MySQL
- Nginx

## Pré-requisitos

- Docker instalado e configurado em seu sistema
- Conhecimento básico do funcionamento do Docker

## Configuração do Ambiente

1. Clone o repositório para sua máquina local.

```bash
git clone https://github.com/viniciusvasconcelosferreira/auth-shield.git
```

2. Navegue até o diretório do projeto.

```bash
cd auth-shield
```

3. Inicialize o ambiente Docker.

```bash
docker-compose up -d
```

4. Instale as dependências do Laravel.

```bash
docker-compose exec app composer install
```

5. Copie o arquivo de configuração do ambiente.

```bash
cp .env.example .env
```

6. Gere a chave de aplicativo do Laravel.

```bash
docker-compose exec app php artisan key:generate
```

7. Configure o arquivo `.env` com as informações do banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=seu_banco_de_dados
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

8. Rode as migrações para criar as tabelas necessárias.

```bash
docker-compose exec app php artisan migrate
```

9. O projeto estará disponível em [http://localhost](http://localhost).

## Uso

- TODO

## Contribuição

Se você quiser contribuir, por favor abra uma issue e/ou envie um pull request.

## Licença

Este projeto está sob a licença [GPL-3.0](LICENSE).