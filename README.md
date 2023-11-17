
## Como instalar

`# git clone https://github.com/edalicioh/arturia-ecommerce.git`
`# cd arturia-ecommerce`
`# docker-compose up -d`
`# docker exec -it arturia-ecommerce_laravel.test_1 composer install`
`# docker-compose down`
`# cp .env.example .env`
`# ./vendor/bin/sail up -d`
`# ./vendor/bin/sail art key:generate`
`# ./vendor/bin/sail art migrate:refresh --seed`
`# ./vendor/bin/sail npm ci && npm run build`


