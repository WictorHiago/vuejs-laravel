# vuejs-laravel
Project Challenge - Crud on Vuejs + Laravel

# Projeto Vuetify-Laravel Backend

Este é o backend do projeto **Vuetify-Laravel**, construído com o **Laravel**. Ele expõe uma API RESTful para manipulação de usuários, com operações CRUD (Create, Read, Update, Delete).

## Autor

Wictor Hiago | Full-Stack Engineer
Linkedin: https://www.linkedin.com/in/dev-wictor-hiago
E-mail: wictor.backup@gmail.com
Portfolio: https://wictordev.vercel.app/

## Requisitos

- PHP >= 8.2
- Composer
- Laravel 11.x
- Banco de Dados PostgreSQL (ou qualquer outro banco compatível)

## Instalação

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

8. Inicie o servidor de desenvolvimento:
    ```bash
    php artisan serve
    ```

Agora a API estará disponível em `http://localhost:8000`.

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
