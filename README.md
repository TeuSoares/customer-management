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

## Inicialização do Projeto

Clone esse repositório:

```bash
git clone https://github.com/TeuSoares/customer-management.git
```	

Para rodar o front-end:
```bash
    cd web
```
```bash
    npm install
```
```bash
    npm run dev
```
```bash
    cp .env.example .env
```
- Configure a variável NEXT_PUBLIC_API_URL no .env, especificando o local que seu back está rodando (Ex: http://localhost:8080)
- Seu front estará rodando em: http://localhost:3000

Configurando o back-end:

- Crie um novo banco de dados e execute o script sql que está dentro da pasta boot em server, no MySQL.
- Execute os comandos abaixo no terminal
```bash
    cd server
```
```bash
    composer install
```
```bash
    cp .env.example .env
```
- Configure no .env criado as seguintes variáveis:
```
DB_CONNECTION=<conexão> // Por padrão deixei como mysql
DB_HOST=<host> // Por padrão deixei como 127.0.0.1
DB_PORT=<porta> // Por padrão deixei como 3306
DB_DATABASE=<nomeDoBanco>
DB_USERNAME=<usuario>
DB_PASSWORD=<senha>

TOKEN_KEY=<chave JWT> // Pode ser qualquer chave
```
- Execute o comando abaixo para rodar o servidor:
```bash
    composer run server
```