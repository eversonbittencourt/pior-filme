

### Instalação

O projeto pode ser executado como uma aplicação Laravel padrão, não possuindo uma prefência de servidor ou ferramenta.

### Requisitos

- Possuir instalado o Node js
- A versão do PHP ulitilizada deve ser 7.1.3 ou versao mais recente.

### Instruções

- Realize o clone do repositório do projeto (git clone https://github.com/eversonbittencourt/news.git).
- No CMD execute o comando ```composer install```.
- Utilizando como base o arquivo .env.example crie um arquivo .env, e sete os dados do banco de dados que deve ser usado como base.
- Atráves do CMD execute o comando ```php artisan migrate``` para gerar as tabelas e na sequência execure o comando ```php artisan db:seed``` que vai alimentar a base com a plalinha de teste que fica na pasta storage.
- Através do CMD acesse o dirétório do projeto e execute o comando ```php artisan serve```, esse comaando vai iniciar o projeto permitindo começar a utilizar a API.


### API

- Os endpoins para utilizar api extão disponíveis no Link do Postman https://documenter.getpostman.com/view/1530036/2s9Ye8fEme


### Teste Unitários

Para executar os testes unitário necessáio executar o comando ```./vendor/bin/phpunit tests/Unit/TestProducers.php```


