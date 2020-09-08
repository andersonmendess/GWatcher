FROM php:7.4-cli

WORKDIR /gwatcher

COPY . .

CMD ["php", "lineage.php"]