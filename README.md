# 🚀 Projeto Laravel - Gerenciamento de Tarefas 📝

### Requisitos Técnicos
* **PHP:** 8.1 ou superior (`>= 8.1`)
* **Composer:** 2.8 ou superior (`>= 2.8`)
* **Banco de Dados:**
    * **PostgreSQL:** 17.4 ou superior (`>= 17.4`)
    * **MySQL:**  - _Observação: O projeto utilizou PostgreSQL._

# Construa e Execute o Projeto

1. Clone o Repositório
```
git clone git remote add origin https://github.com/isaquemenezes/todo-list.git
cd todo-list
```
2. Instalar Dependências
```
composer install

```

3. Configure seu Banco favorito(aqui foi Postgres):
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
``` 
4. Rode as Migrates e Seeds e Levante o servidor :
 ```
 php artisan migrate --seed && php artisan serve
``` 


4. Testar a Aplicação
```
http://127.0.0.1:8000
```

# 🐳 Alternativa: Usando Docker
```
docker-compose up -d

```

## Acessar o projeto 
```
docker-compose exec app bash
```



## ✅ Requisitos Técnicos Alcançados (Todos)

## ✨ Requisitos Funcionais

### 👤 1. Autenticação de Usuários

* O usuário deve ser capaz de usar o login e senha informados durante o cadastro para se autenticar na aplicação.
* A aplicação deverá verificar se o usuário está ativo durante a etapa de login.
* O usuário deve ser capaz de alterar ou recuperar a senha 🔑, em caso de esquecimento.

### ➕ 2. Cadastro de Usuários

* O sistema deve possuir um usuário administrador que será responsável por criar usuários através de um cadastro exclusivo para esse perfil.
* O administrador deve ser capaz de cadastrar novos usuários informando:
    * **Nome:** (obrigatório, mínimo de 3 caracteres, máximo de 200)
    * **E-mail:** (obrigatório, único por usuário, e-mail válido, máximo de 200 caracteres)
    * **Senha:** (obrigatório, mínimo de 8 caracteres, com letras, números e símbolos)
    * **Status:** (obrigatório, booleano)
* A senha deve ser criptografada 🔒 antes de inserir o registro no banco de dados.

### 📄 3. Listagem de Usuários

* Mostrar uma lista com os usuários cadastrados, incluindo:
    * Nome, e-mail e status.
    * Ações para editar ✏️ e excluir 🗑️ a tarefa.

### 🔄 4. Atualização de Usuários

* O administrador poderá atualizar o nome, e-mail, status e senha do usuário seguindo os mesmos critérios do cadastro.

### ❌ 5. Exclusão de Usuários

* O administrador poderá excluir um usuário. Antes da exclusão deve aparecer um modal de confirmação. A exclusão somente poderá ser efetivada se o usuário não estiver relacionado a nenhuma tarefa.

### ✅ 6. Cadastro de Tarefas

* Todos os usuários do sistema devem ser capazes de cadastrar uma nova tarefa informando:
    * **Título:** (obrigatório, mínimo de 3 caracteres, máximo de 255).
    * **Descrição:** (opcional, máximo de 500 caracteres).
    * **Status:** (pendente ou concluída).
* Ao realizar o cadastro, a tarefa deve ser automaticamente vinculada ao usuário que criou a tarefa.

### 📑 7. Listagem de Tarefas

* Mostrar uma lista com as tarefas cadastradas, incluindo:
    * Título, descrição e status.
    * Ações para editar ✏️ e excluir 🗑️ a tarefa.
* A listagem deve trazer, por padrão, apenas as tarefas vinculadas ao usuário logado. Entretanto, o filtro pode ser alterado para mostrar tarefas vinculadas a outras pessoas.

### 🧑‍🤝‍🧑 8. Gerenciar Usuários das Tarefas

* Todos os usuários do sistema devem ser capazes de gerenciar as pessoas envolvidas na tarefa, adicionando ou removendo pessoas, inclusive a si mesmo.

### 👍 9. Marcar Tarefa como Concluída

* Todos os usuários do sistema devem ser capazes de marcar a tarefa como concluída através de um clique.

### ✍️ 10. Atualização de Tarefas

* O usuário deve poder atualizar o título, descrição ou status de uma tarefa seguindo os mesmos critérios do cadastro.

### 💣 11. Exclusão de Tarefas

* O usuário deve poder excluir uma tarefa. Antes da exclusão, deve aparecer um modal de confirmação.

### 🔍 12. Pesquisa e Filtro de Tarefas

* Permitir a pesquisa de tarefas pelo título.
* Filtrar as tarefas pelo status (pendente ou concluída).
* Filtrar as tarefas por pessoas.

## ⚙️ Requisitos Técnicos

### 🧱 1. Backend

* Utilizar Laravel 10 para gerenciar o backend.
* As rotas devem ser organizadas em um Resource Controller.
* As validações devem ser feitas usando Form Requests.
* A aplicação deve utilizar Eloquent ORM para acessar o banco de dados.
* Utilizar middlewares, policies ou gates para verificação de permissões de acesso quando aplicável.
* Criar Migrations para as tabelas do banco de dados.
* Utilizar transações de banco de dados durante cadastros, edições e exclusão dos registros das tabelas.
* Criar mensagens de feedback para ações do CRUD (ex.: "Tarefa criada com sucesso!").
