# Projeto backend-challenge

### Ferramentas utilizadas

- UBUNTU 20.04
- PHP 7.4
- Framework Laravel 8
- mysql  Ver 8.0.28-0ubuntu0.20.04.3 for Linux on x86_64 ((Ubuntu))
- guzzleHttp 7.4
- Frontend baseado no painel admin: https://github.com/oryfikry/laravel-8-boilerplate

### Para instalação

** Necessário composer **
```
https://getcomposer.org/
```

* Fazer o download do projeto
```
git clone https://github.com/rgllopes/backend-challenge.git
```
* Renomear o arquivo.env.exemple para .env
* Verificar se as variáveis para acesso a api eLearn estão inseridas no final do arquivo .env

TOKEN_MLEARN="BrSdaY0rV8ONh409KopUtcVpCtBgs6pjbQytMV5z"
BASE_URI_MLEARN="https://api.staging.mlearn.mobi"

* Rodar composer para instalação das dependências
```
composer install
```

* Gerar chave de acesso laravel "Key generate"
```
php artisan key:generate
```

* Criar uma base de dados em MySQL com o nome de sua escolha

* Configurar arquivo .env com dados de acesso a base de dados
DB_CONNECTION='mysql'
DB_HOST='127.0.0.1'
DB_PORT='3306'
DB_DATABASE='laravel'
DB_USERNAME='root'
DB_PASSWORD=''

* Realizar a migração das tabelas para sua base de dados
```
php artisan migrate
```

* Inicializar servidor
```
php artisan serve
```

#### Na migração é criado um usuário admin que não pode ser apagado pelo sistema
Usuário: admin@admin.com </br>
Senha: 12345678

## ENJOY!