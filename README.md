# Projeto backend-challenge

### Ferramentas utilizadas

- UBUNTU 20.04
- PHP 7.4
- Framework Laravel 8
- mysql  Ver 8.0.28-0ubuntu0.20.04.3 for Linux on x86_64 ((Ubuntu))
- guzzleHttp 7.4
- Frontend baseado no painel admin https://github.com/oryfikry/laravel-8-boilerplate

### Para instalação

** Necessário composer **
```
https://getcomposer.org/
```


```
git clone https://github.com/rgllopes/backend-challenge.git
```

* Rodar composer para instalação das dependências
```
composer install
```

* Gerar chave de acesso laravel "Key generate"
```
php artisan key:generate
```

* Criar uma base de dados em MySQL com o nome de sua escolha

* Renomear o arquivo.env.exemple para .env

* Configurar arquivo .env com dados de acesso a base de dados

* Realizar a migração das tabelas para sua base de dados
```
php artisan migrate
```

* Inicializar servidor
```
php artisan serve
```

#### Na migração é criado um usuário admin que não pode ser apagado pelo sistema
Usuário: admin@admin.com
Senha: 12345678
