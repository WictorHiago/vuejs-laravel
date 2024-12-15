# vuejs-laravel
Project Challenge - Crud on Vuejs + Laravel

## Navegação
- [Requisitos](#requisitos)
- [PostgreSQL](#postgresql)
- [Backend](#diretório-backend)
- [Frontend](#diretório-frontend)
- [API Endpoints](#endpoints-da-api)
- [Contribuição](#contribuição)
- [Licença](#licença)

## Autor

Wictor Hiago | Full-Stack Engineer
Linkedin: https://www.linkedin.com/in/dev-wictor-hiago
E-mail: wictor.backup@gmail.com
Portfolio: https://wictordev.vercel.app/

## Requisitos

- Docker
- Node.js >= 18
- PHP >= 8.2
- Composer
- Laravel 11.x
- Vue.js 3.x
- Vuetify 3.x
- Banco de Dados PostgreSQL

## POSTGRESQL

Crie a imagem do banco de dados PostgreSQL e inicie o container:

Via Docker Compose:

```bash
docker-compose up -d
```

Via comando Docker:

```bash
docker run -d --name postgres_laravel -p 5432:5432 -e POSTGRES_DB=laravel_db -e POSTGRES_USER=postgres -e POSTGRES_PASSWORD=postgres postgres:15-alpine
```

## Diretório Backend

1. Clone o repositório:
    ```bash
    git clone https://github.com/usuario/vuetify-laravel.git
    ```

2. Navegue até o diretório do backend:
    ```bash
    cd vuetify-laravel/backend
    ```

3. Instale as dependências com o Composer:
    ```bash
    composer install
    ```

4. Crie o arquivo `.env`:
    ```bash
    cp .env.example .env
    ```

5. Configure as variáveis de ambiente no arquivo `.env`, como as credenciais do banco de dados.

6. Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```

7. Execute as migrações para criar as tabelas no banco de dados:
    ```bash
    php artisan migrate
    ```

8. Execute os seeders para popular o banco de dados:
    ```bash
    php artisan db:seed
    ```

9. Inicie o servidor de desenvolvimento:
    ```bash
    php artisan serve
    ```

O backend estará disponível em `http://localhost:8000`.

## Diretório Frontend

1. Navegue até o diretório do frontend:

    ```bash
    cd vuetify-laravel/front-end
    ```

2. Instale as dependências:

    ```bash
    npm install
    ```

3. Inicie o servidor de desenvolvimento:
    ```bash
    npm run dev
    ```

O frontend estará disponível em `http://localhost:3000`.

### Funcionalidades do Frontend

- **Lista de Usuários**: Visualize todos os usuários cadastrados
- **Criar Usuário**: Adicione novos usuários ao sistema
- **Editar Usuário**: Atualize informações de usuários existentes
- **Excluir Usuário**: Remova usuários do sistema
- **Validação de Formulários**: Validação em tempo real dos campos
- **Feedback Visual**: Notificações de sucesso/erro nas operações
- **Design Responsivo**: Interface adaptável para diferentes dispositivos

## Endpoints da API

Abaixo estão os detalhes sobre os endpoints da API que você pode usar para gerenciar os usuários.

### 1. **Listar todos os usuários**
- **Método**: `GET`
- **URL**: `/users`
- **Descrição**: Retorna todos os usuários cadastrados.
- **Resposta de Sucesso**:
    ```json
    {
        "users": [
            {
                "id": 1,
                "name": "Wictor Hiago Souza Conceicao",
                "email": "wictor.1@gmail.com",
                "cpf": "01234567890"
            },
            {
                "id": 2,
                "name": "Olivia Souza",
                "email": "olivia.4@gmail.com",
                "cpf": "09876543210"
            }
        ]
    }
    ```

### 2. **Criar um novo usuário**
- **Método**: `POST`
- **URL**: `/users`
- **Body**:
    ```json
    {
        "name": "Nome do Usuário",
        "email": "email@dominio.com",
        "cpf": "12345678901",
        "password": "senha123"
    }
    ```
- **Resposta de Sucesso**:
    ```json
    {
        "message": "Usuário criado com sucesso!",
        "user": {
            "id": 3,
            "name": "Nome do Usuário",
            "email": "email@dominio.com",
            "cpf": "12345678901"
        }
    }
    ```

### 3. **Exibir detalhes de um usuário**
- **Método**: `GET`
- **URL**: `/users/{id}`
- **Descrição**: Retorna os detalhes de um usuário específico pelo `id`.
- **Resposta de Sucesso**:
    ```json
    {
        "user": {
            "id": 1,
            "name": "Wictor Hiago Souza Conceicao",
            "email": "wictor.1@gmail.com",
            "cpf": "01234567890"
        }
    }
    ```

- **Resposta de Erro**:
    ```json
    {
        "error": "Usuário não encontrado"
    }
    ```

### 4. **Atualizar um usuário**
- **Método**: `PUT`
- **URL**: `/users/{id}`
- **Body**:
    ```json
    {
        "name": "Nome Atualizado",
        "email": "novo-email@dominio.com",
        "cpf": "12345678901",
        "password": "nova-senha"
    }
    ```
- **Resposta de Sucesso**:
    ```json
    {
        "message": "Usuário atualizado com sucesso!",
        "user": {
            "id": 1,
            "name": "Nome Atualizado",
            "email": "novo-email@dominio.com",
            "cpf": "12345678901"
        }
    }
    ```

### 5. **Excluir um usuário**
- **Método**: `DELETE`
- **URL**: `/users/{id}`
- **Descrição**: Exclui o usuário especificado pelo `id`.
- **Resposta de Sucesso**:
    ```json
    {
        "message": "Usuário excluído com sucesso!"
    }
    ```

---

## Contribuição

Sinta-se à vontade para fazer um fork deste repositório, melhorar o código e criar pull requests.

---

## Licença

Este projeto está sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
