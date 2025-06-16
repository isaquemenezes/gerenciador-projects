# 🚀 Projeto Laravel - Gerenciamento de Projetos 📝

### Requisitos Técnicos
* **PHP:** 8.1 ou superior (`>= 8.1`)
* **Composer:** 2.8 ou superior (`>= 2.8`)
* **Banco de Dados:**
    * **PostgreSQL:** 17.4 ou superior (`>= 17.4`)
    * **MySQL:**  - _Observação: O projeto utilizou PostgreSQL._

# Construa e Execute o Projeto

1. Clone o Repositório
```
git clone https://github.com/isaquemenezes/gerenciador-projects.git
cd gerenciador-projects
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

5. Rode os teste :
 ```
 php artisan test
``` 


6. Testar a Aplicação
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
