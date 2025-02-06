# 🎲 API de Sorteios de Loteria - Monetizze

## 📌 Sobre o Projeto
Esta API foi desenvolvida para gerenciar sorteios internos de brindes para os funcionários da **Monetizze**. O sistema permite que os colaboradores gerem bilhetes para participar de sorteios e que um bilhete premiado seja sorteado.

A API segue os princípios de **boas práticas de programação**, **clean code**, **desacoplamento de responsabilidades** e **uso do MVC (Model-View-Controller)**.

---

## 🚀 Tecnologias Utilizadas
- **PHP 8.1** (Sem framework, seguindo o requisito)
- **MySQL 8.0** (Banco de dados relacional)
- **Illuminate Database (Eloquent ORM)** (Gerenciamento de banco de dados)
- **Docker & Docker Compose** (Ambiente de desenvolvimento)
- **Composer** (Gerenciador de dependências PHP)
- **Apache 2.4** (Servidor HTTP)

---

## 📂 Estrutura do Projeto
```
📦 loteria-api
├── 📂 config/            # Configurações do banco de dados e variáveis de ambiente
├── 📂 database/          # Migrations e scripts de banco
├── 📂 public/            # Pasta pública (index.php e .htaccess)
├── 📂 src/               # Código principal da aplicação
│   ├── 📂 controllers/   # Controladores das rotas
│   ├── 📂 models/        # Modelos (Eloquent ORM)
│   ├── 📂 services/      # Serviços com regras de negócio
│   ├── 📂 routes.php     # Definição de rotas
│   ├── 📂 bootstrap.php  # Inicialização da aplicação
├── 📂 tests/             # Testes unitários
├── .env                 # Variáveis de ambiente
├── docker-compose.yml    # Configuração do ambiente Docker
├── README.md             # Documentação do projeto
└── composer.json         # Dependências do projeto
```

---

## ⚙️ Como Rodar o Projeto

### **1️⃣ Pré-requisitos**
Antes de começar, certifique-se de ter instalado:
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/)
- [Composer](https://getcomposer.org/)

### **2️⃣ Clonar o repositório**
```sh
git clone https://github.com/PabloLopesLVT/loteria-api.git
cd loteria-api
```

### **3️⃣ Instalar as Dependências**
```sh
composer install
```

### **4️⃣ Criar e Configurar o Banco de Dados**
Renomeie o arquivo `.env.example` para `.env` e configure as credenciais do banco de dados:
```sh
cp .env.example .env
```

Se necessário, edite as variáveis do banco de dados no `.env`:
```ini
DB_HOST=mysql_db
DB_DATABASE=loteria
DB_USERNAME=user
DB_PASSWORD=password
```

### **5️⃣ Subir o Ambiente com Docker**
```sh
docker-compose up -d --build
```

### **6️⃣ Rodar as Migrations** (Criar tabelas no banco)
```sh
docker exec -it php_app bash
php database/migrate.php
```

---

## 📡 Endpoints da API
### **🔹 Gerar Bilhetes**
- **Rota:** `POST /bilhetes`
- **Corpo da requisição:**
```json
{
  "qtdeBilhetes": 5,
  "qtdeDezenas": 6
}
```
- **Resposta:**
```json
{
  "message": "Bilhetes gerados e salvos com sucesso!",
  "bilhetes": [...]
}
```

### **🔹 Listar Bilhetes**
- **Rota:** `GET /bilhetes`
- **Resposta:** HTML contendo uma tabela com os bilhetes gerados.

### **🔹 Sortear Bilhete Premiado**
- **Rota:** `GET /bilhete/premiado`
- **Resposta:** JSON contendo o bilhete premiado.

---


## 🛑 O Que a API **Não** Faz
- **Não possui autenticação** (todos podem acessar os endpoints)
- **Não tem UI gráfica** (apenas JSON e HTML gerado para exibição de bilhetes)
- **Não possui controle de sorteio por data** (é necessário adicionar  no futuro)

---

## 🔥 Melhorias Futuras
- ✅ Adicionar autenticação JWT para maior segurança
- ✅ Implementar paginação para listagem de bilhetes
- ✅ Criar testes automatizados e rodá-los em CI/CD
- ✅ Implementar solução para controlar os sorteios por data

---

## 🏆 Code Smells e Melhorias Pendentes
- **Envio de JSON na listagem de bilhetes** → Atualmente retorna HTML, pode ser melhor estruturado.

---


Desenvolvido por **Pablo Lopes** 🚀

