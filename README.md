# Desafio Fullstack 💡

Projeto fullstack com backend (PHP/Laravel) e frontend (React), utilizando banco de dados relacional e Docker para orquestração.

## Tecnologias 🖥️

- **Backend:** Laravel/PSP, PostgreSQL
- **Frontend:** React
- **UI**: Mantine.dev
- **Orquestração:** Docker, Docker Compose

---

## Como subir o projeto 🚀

1. Clone o repositório:
  ```bash
  git clone https://github.com/thiagoandre-dev/desafio-fullstack.git
  cd desafio-fullstack
  ```

2. Copie os arquivos de exemplo de ambiente:
  ```bash
  cp backend/.env.example backend/.env
  cp frontend/.env.example frontend/.env
  ```

3. Suba os containers:
  ```bash
  docker-compose up --build
  ```

4. Execute as migrations do banco de dados:
  ```bash
  docker exec desafio_backend php artisan migrate
  ```

---

## Migrations 🗄️

As migrations são necessárias para criar as tabelas no banco de dados. Execute o comando acima após subir os containers.

---

## Para executar o Frontend sem o Docker 🎨

- Local: `frontend/`
- Para desenvolvimento local:
  ```bash
  cd frontend
  npm install
  npm run dev
  ```
- O frontend consome a API do backend.

---

## Para executar o Backend sem o Docker 🚀

- Local: `backend/`
- Para desenvolvimento local:
  ```bash
  cd backend
  composer install
  php artisan serve
  ```
- O backend expõe endpoints RESTful.

---

## Chamadas de API 

### Níveis 🏅

#### Lista de níveis

- `GET /api/niveis`
  - **Headers:** `Accept: application/json`
  - **Query Params:**
    - `limit` (opcional): número máximo de itens por página
    - `page` (opcional): número da página para paginação
    - `nivel` (opcional): filtra resultados pelo nível informado
  - **Exemplo:**
    ```
    GET /api/niveis?limit=10&page=2&nivel=senior
    ```
  - **Response:** 200 - Lista de níveis

#### Buscar nível por ID

- `GET /api/niveis/{id}`
  - **Headers:** `Accept: application/json`
  - **Parâmetros de rota:**
    - `id`: ID do nível a ser buscado
  - **Exemplo:**
    ```
    GET /api/niveis/1
    ```
  - **Response:** 200 - Dados do nível correspondente ao ID informado

#### Criar novo nível

- `POST /api/niveis`
  - **Headers:** `Accept: application/json`
  - **Body (JSON):**
    ```json
    {
      "nivel": "Pleno"
    }
    ```
  - **Response:** 201 - Dados do nível criado

#### Alterar nível

- `PUT /api/niveis/{id}`
  - **Headers:** `Accept: application/json`
  - **Parâmetros de rota:**
    - `id`: ID do nível a ser alterado
  - **Body (JSON):**
    ```json
    {
      "nivel": "Senior"
    }
    ```
  - **Response:** 200 - Dados do nível atualizado

#### Excluir nível

- `DELETE /api/niveis/{id}`
  - **Headers:** `Accept: application/json`
  - **Parâmetros de rota:**
    - `id`: ID do nível a ser excluído
  - **Exemplo:**
    ```
    DELETE /api/niveis/1
    ```
  - **Response:** 204 - Confirmação da exclusão do nível

### Desenvolvedores 👨‍💻

#### Lista de desenvolvedores

- `GET /api/desenvolvedores`
  - **Headers:** `Accept: application/json`
  - **Query Params:**
    - `limit` (opcional): número máximo de itens por página
    - `page` (opcional): número da página para paginação
    - `nome` (opcional): filtra resultados pelo nome informado
  - **Exemplo:**
    ```
    GET /api/desenvolvedores?limit=10&page=1&nome=joao
    ```
  - **Response:** 200 - Lista de desenvolvedores

#### Buscar desenvolvedor por ID

- `GET /api/desenvolvedores/{id}`
  - **Headers:** `Accept: application/json`
  - **Parâmetros de rota:**
    - `id`: ID do desenvolvedor a ser buscado
  - **Exemplo:**
    ```
    GET /api/desenvolvedores/1
    ```
  - **Response:** 200 - Dados do desenvolvedor correspondente ao ID informado

#### Criar novo desenvolvedor

- `POST /api/desenvolvedores`
  - **Headers:** `Accept: application/json`
  - **Body (JSON):**
    ```json
    {
      "nome": "João Silva",
      "nivel_id": 2,
      "sexo": "M", // "M" ou "F"
      "data_nascimento": "1990-05-10", // formato YYYY-MM-DD
      "hobby": "Futebol"
    }
    ```
  - **Response:** 201 - Dados do desenvolvedor criado

#### Alterar desenvolvedor

- `PUT /api/desenvolvedores/{id}`
  - **Headers:** `Accept: application/json`
  - **Parâmetros de rota:**
    - `id`: ID do desenvolvedor a ser alterado
  - **Body (JSON):**
    ```json
    {
      "nome": "João Souza",
      "nivel_id": 3,
      "sexo": "M", // "M" ou "F"
      "data_nascimento": "1990-05-10", // formato YYYY-MM-DD
      "hobby": "Leitura"
    }
    ```
  - **Response:** 200 - Dados do desenvolvedor atualizado

#### Excluir desenvolvedor

- `DELETE /api/desenvolvedores/{id}`
  - **Headers:** `Accept: application/json`
  - **Parâmetros de rota:**
    - `id`: ID do desenvolvedor a ser excluído
  - **Exemplo:**
    ```
    DELETE /api/desenvolvedores/1
    ```
  - **Response:** 204 - Confirmação da exclusão do desenvolvedor

## Licença ⚖️

MIT