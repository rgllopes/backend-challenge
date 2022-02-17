# Projeto backend-challenge

### Ferramentas utilizadas

- UBUNTU version 20.04 LTS
- PHP version 7.4
- mysql  version 8.0.28-0
- Framework Laravel 8: https://laravel.com/docs/8.x
- guzzleHttp 7.4: https://docs.guzzlephp.org/en/stable/

### Para instalação

** Necessário composer **
```
https://getcomposer.org/
```
** Necessário npm(Node.js) **
```
https://nodejs.org/en/download/
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

* Rodar npm para instalação de dependências
```
npm install && npm run dev
```
#### OBS: pode ser necessário rodar "npm run dev" (sem aspas) uma segunda vez para atualização de scaffold

* Gerar chave de acesso laravel "Key generate"
```
php artisan key:generate
```

* Criar uma base de dados em MySQL com o nome de sua escolha

* Configurar arquivo .env com os dados de acesso de sua base de dados crada anteriormente:<br>
DB_CONNECTION='mysql'</br>
DB_HOST='127.0.0.1'</br>
DB_PORT='3306'</br>
DB_DATABASE='laravel'</br>
DB_USERNAME='root'</br>
DB_PASSWORD=''</br>

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