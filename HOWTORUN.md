# How to Run

## Pré-requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Configuração 

### 1. Clone o repositório do projeto

### 2. Configure o arquivo `.env`
Copie o arquivo de exemplo e edite conforme necessário:
```sh
cp .env.example .env
```
Edite o `.env` e configure as variáveis, como as credenciais do banco de dados definidas no `docker-compose.yml`.

## Executando o projeto

### 4. Iniciar os contêineres
Execute o comando:
```sh
docker compose up --build -d
```
- `--build` garante que as imagens sejam reconstruídas.
- `-d` executa os contêineres em segundo plano.

### 5. Verifique os logs:
```sh
docker compose logs -f
```

## Possíveis erros e soluções

### 1. **Chave da aplicação não gerada (`APP_KEY`)**
Se ocorrer o erro:
```sh
No application encryption key has been specified.
```
Execute dentro do contêiner `backend`:
```sh
docker exec -it backend php artisan key:generate
```

### 2. **`JWT_SECRET` não gerado**
Se o `JWT_SECRET` não foi gerado corretamente:
```sh
docker exec -it backend php artisan jwt:secret
```

### 3. **Dependências do composer não instaladas corretamente**
Se o Laravel não funcionar corretamente:
```sh
docker exec -it backend composer install --no-interaction
```

### 4. **Dependências do NPM não instaladas corretamente**
Se o frontend apresentar erros de dependência:
```sh
docker exec -it frontend npm install
```

### 5. **Banco de dados não disponível na inicialização**
Se o Laravel não conseguir conectar ao banco de dados, reinicie o backend:
```sh
docker compose restart backend
```
Ou verifique a conexão manualmente:
```sh
docker exec -it database mysql -u root -p
```
(Senha padrão: `root`, conforme `docker-compose.yml`)

## Testando o projeto

### Backend
A API estará disponível em:
```sh
http://localhost:8000/api
```

### Frontend
O frontend estará disponível em:
```sh
http://localhost:8080
```

## Final

Para parar e remover os contêineres:
```sh
docker compose down
```
Se quiser remover também os volumes:
```sh
docker compose down -v
```

