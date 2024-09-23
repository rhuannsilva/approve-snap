<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Approve-Snap

**Approve-Snap** é um projeto desenvolvido em Laravel 11 com PHP 8.3, utilizando Docker Compose para facilitar o ambiente de desenvolvimento.

## Requisitos

- **Docker**: Certifique-se de que o Docker e o Docker Compose estão instalados no seu sistema.

## Tecnologias utilizadas

- **Laravel 11**
- **PHP 8.3**
- **Postgres**
- **Nginx**
- **Docker Compose**

## Instalação e Configuração

Siga as etapas abaixo para configurar o projeto localmente:

1. **Clone o repositório:**

```sh
git clone https://github.com/rhuannsilva/approve-snap.git
```

2. **Crie o arquivo .env**

3. **Suba os containers com docker compose**

```sh
docker-compose up -d
```

4. **Aguarde os comandos serem executados no container do php**

```sh
composer install &&
npm install &&
npm run build &&
php artisan migrate --force &&
php-fpm
```

5. **Acesse a url do container php por padrao localhost:9000**

