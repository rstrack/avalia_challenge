# Desafio Avalia

## Dependências

- [MySQL versão >=8.0.30](https://downloads.mysql.com/archives/installer/)
- [Node versão >=18.17.1](https://nodejs.org/pt-br/download)
- [PHP versão >=8.2.9](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)

## Rodando o projeto

- Crie o arquivo **.env** nas pastas _client_ e _server_, usando como base os arquivos **example.env** disponíveis;

- Abra o terminal na pasta raíz do projeto e copie os comandos abaixo:

```
    cd server
    composer install
    php artisan migrate
    php artisan serve

    cd ../client
    npm i
    npm run dev

```
