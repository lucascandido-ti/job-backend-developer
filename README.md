# API desenvolvida para CRUD de produtos
***

Olá, :D

Essa aplicação é uma API REST, onde pode ser consumida por outros sistemas. Esta API possui um gerenciamento de um catálogo de produtos e importação em massa.

## O que temos em nossa API

- CRUD através de uma API REST com Laravel;
- Comando artisan que se comunica com uma API para importar novos produtos;

## Começando

### Configuração do ambiente
***

**Para configuração do ambiente é necessário ter o [Docker](https://docs.docker.com/desktop/) instalado em sua máquina.**

Dentro da pasta do projeto, rode o seguinte comando: `docker-compose up -d`.

Copie o arquivo `.env.example` a renomeie para `.env` dentro da pasta raíz da aplicação.

```bash
cp .env.example .env
```

Após criar o arquivo `.env`, será necessário acessar o container da aplicação para rodar alguns comandos de configuração do Laravel.

Para acessar o container use o comando `docker exec -it yampi_test_app sh`.

Digite os seguintes comandos dentro do container:

```bash
composer install
php artisan key:generate
php artisan migrate
```

Após rodar esses comandos, seu ambiente estará pronto.

Para acessar a aplicação, basta acessar `localhost:8000`

### Funcionalidades

##### CRUD produtos

Para o gerenciamento do CRUD de produtos, criamos os seguintes endpoints:
```ruby
"GET|HEAD"        api/admin/products ............. products.index › ProductController@index
"POST"            api/admin/products ............. products.store › ProductController@store
"POST"            api/admin/products/search ...... products.seach › ProductController@search
"GET|HEAD"        api/admin/products/"{product}" ... products.show › ProductController@show
"PUT|PATCH"       api/admin/products/"{product}" ... products.update › ProductController@update
"DELETE"          api/admin/products/"{product}" ... products.destroy › ProductController@destroy
```

Na pasta "Postman" você ira encontrar um arquivo de importação de um collection com todos os endpoints da aplicação, com todos os parâmetros especificados.

##### Estrutura do retorno da busca de produtos
```json
{
    "data": [
        {
            "id": 1,
            "name": "product name",
            "price": 109.95,
            "description": "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...",
            "category": "test",
            "image": "https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg"
        }
    ]
}
```

##### Estrutura do payload
```json
{
      "name": "product name",
      "price": 109.95,
      "description": "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...",
      "category": "test",
      "image_url": "https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg"
}
```

**Importante:** Todos os endpoints de criação e atualização, possuem uma camada de validação dos campos.

##### Eventos

Ao adicionar um produto no sistema ou atualiza-lo, é gerado um evento onde é enviado um email com os dados do produto para um responsável.

Temos um container que armazena nosso servidor de email de teste, o Mailhog.
Então pasta acessar o link `http://localhost:8025` que conseguira ver os email recebidos.

##### Buscas de produtos

Para realizar a manutenção de um catálogo de produtos o sistema possui algumas buscas, sendo elas:

- Busca pelos campos `name` e `category` (trazendo resultados que batem com ambos os campos).
- Busca por uma categoria específica.
- Busca de produtos com e sem imagem.
- Buscar um produto pelo seu ID único.

##### Importação de produtos de uma API externa

O sistema é capaz de importar produtos que estão em um outro serviço. Então foi criado um comando que buscar produtos através da FakeStoreAPI e armazena os resultados no base de dados. 

##### Informação importante antes do processamento
Antes de testar a importação, é importante lembrar que utilizamos Redis para gerenciar nossas filas.
Para a importação dos produtos temos um Job que é responsavel por adicionar nossa requisição na fila.
Sendo assim precisamos iniciar nosso worker para que a fila seja processada.

1º Acesse o container usando o comando `docker exec -it yampi_test_app sh`;

2º Comando para iniciar nosso worker: `php artisan queue:work redis --tries=3`

Prontinho, worker em funcionamento.

##### Comandos de importação

Comando para importação de todos os produtos da API: `php artisan products:import`;

Comando para importação de um produto especifico: `php artisan products:import id=11`;

Este comando ira buscar os dados dos produtos neste serviço externo (FakeStoreAPI), e ira importar em nosso banco.

Se o produto já existir em nossa base, ele fará uma atualização no produto, mas se ele não existir ele será inserido.

Documentação da API utilizada para importar os produtos: [https://fakestoreapi.com/docs](https://fakestoreapi.com/docs)

---

Linkedin: https://www.linkedin.com/in/lucascandido-ti/

