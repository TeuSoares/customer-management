# Gerenciamente de Clientes

Uma área administrativa para o usuário conseguir gerenciar seus clientes.

## O que foi utilizado

Front-end
* Next.js
* TypeScript
* Tailwind CSS
* Shadcn/ui
* Formulários com React-Hook-Form e Zod
* React Query

Back-end
* PHP 8.2
* Banco de dados MySql
* JWT para autenticação

## Funcionalidades
* [x] Cadastro de usuários administrator
* [x] Carregamento na dashboard de todos os cliente pertencente ao usuário logado.
* [x] Adicionar um novo cliente para o usuário logado.
* [x] Visualizar as informação de determinado cliente, de acordo com o ID
* [x] Cadastro de endereços para determinado cliente
* [x] Deletar um cliente
* [x] Deletar um endereço, pertencente a um cliente
* [x] Atualizar os dados de um cliente

## Inicialização do Projeto

Clone esse repositório:

```bash
git clone https://github.com/TeuSoares/customer-management.git
```

### Front-end:

Instalar as dependências e iniciar. 
```bash
    cd web
```
```bash
    npm install
```
```bash
    npm run dev
```

Se quiser utilizar docker, basta rodar o comando
```bash
    cd web
```
```bash
    docker compose up -d
```

Crie o .env na raiz do projeto web
```bash
    cp .env.example .env
```

Configure a variável NEXT_PUBLIC_API_URL no .env, especificando o local que seu back está rodando (Ex: http://localhost:8080)

Seu front estará rodando em: http://localhost:3000

### Configurando o back-end:

Instalando as dependências
```bash
    cd server
```
```bash
    composer install ou docker compose run --rm composer install
```

Crie o .env e configure as variáveis necessárias
```bash
    cp .env.example .env
```
```
DB_CONNECTION=<conexão> // Por padrão deixei como mysql
DB_HOST=<host> // Padrão 127.0.0.1, mas se estiver utilizando docker, defina como mysql
DB_PORT=<porta> // Por padrão deixei como 3306
DB_DATABASE=<nomeDoBanco>
DB_USERNAME=<usuario>
DB_PASSWORD=<senha>

TOKEN_KEY=<chave JWT> // Pode ser qualquer chave
```

Iniciar o servidor sem Docker

- Você pode utilizar o servidor embutido do PHP. Para isso rode o comando:

```bash
    composer run server
```
``Esse comando irá iniciar um servidor embutido PHP na porta 8080 dentro da pasta public do projeto``

- Se estiver utilizando o apache, existe duas possibilidades para rodar o projeto.

1. Na variavel NEXT_PUBLIC_API_URL no .env do front. Deverá ser especificado o local onde está o projeto
  ``Ex: http://localhost/<pasta_principal>/server/public``

1. Outra possibilidade é adicionar o .htaccess abaixo dentro da pasta root do apache. (Ex: www), redirecionando para a pasta public dentro de server.
   
    ```
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/nomeDaPastaPrincipal/server/public/
    RewriteRule ^(.*)$ /nomeDaPastaPrincipal/server/public/$1 [L]
    ```

Iniciando com Docker:
```bash
    docker compose up -d nginx
```
``Irá subir para você o container do PHP, MySQL, PHPMyAdmin e Nginx``

``O servidor vai rodar em http://localhost:8080``

Configurando o banco de dados
   - Crie um novo banco de dados e execute o script sql que está dentro da pasta bootstrap em server, no MySQL.
   - Caso esteja utilizando com docker, o PHPMyAdmin vai estar rodando em: ``http://localhost:8081``
   - Um caminho mais rápido, é você logo após ter criado seu banco de dados e configurado as conexões no .env, você poderá executar o comando ```composer run migrate``` ou se estiver utilizando docker ```docker compose run --rm composer run migrate```. Dessa forma todas as tabelas serão migradas para o banco e dados.
