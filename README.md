
# Weather API Project

Este projeto é uma API simples em PHP para consulta de informações meteorológicas, com controle de acesso por IP e autenticação via token.

A API está online e disponível em: [https://weather.lolfy.com.br](https://weather.lolfy.com.br)  
A documentação Swagger está disponível em: [https://weather.lolfy.com.br/swagger/index.html](https://weather.lolfy.com.br/swagger/index.html)

## Funcionalidades

- **Consulta de clima**: Endpoint `https://weather.lolfy.com.br/weather` para obter informações meteorológicas.
- **Controle de IP**: Apenas IPs cadastrados podem acessar o endpoint `https://weather.lolfy.com.br/weather`.
- **Cadastro de IP**: Endpoint `https://weather.lolfy.com.br/subscribeIp` para cadastrar novos IPs autorizados (requer token de autenticação).
- **Variáveis de ambiente**: Utiliza arquivo `.env` para configuração de variáveis sensíveis, como o token de identificação da api usada para obter os dados https://openweathermap.org/.

## Estrutura do Projeto

- `index.php`: Arquivo principal de roteamento da API.
- `functions.php`: Funções auxiliares utilizadas pela API.
- `pages/weather.php`: Implementação da lógica de consulta do clima.
- `ips.json`: Lista de IPs autorizados.
- `vendor/`: Dependências gerenciadas pelo Composer.

## Instalação

1. Clone o repositório:
   ```sh
   git clone <url-do-repositorio>


2. Instale as dependências via Composer:

   ```sh
   composer install
   ```
3. Crie um arquivo `.env` na raiz do projeto com o seguinte conteúdo:

   ```env
   OWM_API_KEY = 'CHAVE_OPEN_WEATHER'
   OAUTH_TOKEN = '7126asjhsdakgsd871yg21aksj'
   ```
4. (Opcional) Adicione IPs autorizados no arquivo `ips.json`:

   ```json
   ["127.0.0.1"]
   ```

## Como Usar

### 1. Consultar Clima

* **Endpoint:** `/weather`

* **Método:** `GET`

* **Requisito:** O IP do cliente deve estar cadastrado em `ips.json`.

* **Parâmetros de Query:**

  * `cidade` (obrigatório): Nome da cidade, ex: `São Paulo`
  * `unidade` (opcional): Unidade de temperatura (`c` = Celsius, `f` = Fahrenheit). Padrão: `c`

* **Exemplo:**

  ```sh
  curl "https://weather.lolfy.com.br/weather?cidade=São+Paulo&unidade=c"
  ```

### 2. Cadastrar Novo IP

* **Endpoint:** `https://weather.lolfy.com.br/subscribeIp`
* **Método:** `POST`
* **Body:**

  * `token`: Token de autenticação definido no `.env`.
 
* **Exemplo:**

  ```sh
  curl -X POST -d "token=7126asjhsdakgsd871yg21aksj" https://weather.lolfy.com.br/subscribeIp
  ```
<img width="1485" height="694" alt="image" src="https://github.com/user-attachments/assets/13c66ba2-79c4-452e-aca8-c02123eb9c94" />

## Documentação Swagger

A API possui documentação interativa gerada com Swagger, que permite testar endpoints diretamente pelo navegador. O Swagger foi utilizado para:

* Facilitar a compreensão de todos os endpoints disponíveis.
* Mostrar parâmetros, respostas e exemplos de forma visual.
* Permitir testes rápidos sem precisar de um cliente externo.

Acesse a documentação Swagger em: [http://weather.lolfy.com.br/swagger/index.html](http://weather.lolfy.com.br/swagger/index.html)
Para testar qualquer endpoint basta acessar a documentação do [swagger](http://weather.lolfy.com.br/swagger/index.html) e clicar em "try it out", conforme mostra a imagem abaixo
<img width="1493" height="878" alt="image" src="https://github.com/user-attachments/assets/3f19dbb3-09b2-468e-a564-53d5d0d519f0" />

## Observações

* O projeto utiliza a biblioteca [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) para gerenciamento de variáveis de ambiente.
* Certifique-se de que o servidor web tenha permissão de escrita no arquivo `ips.json`.

## Licença

Este projeto está sob a licença MIT.

```

Se você quiser, posso gerar também **uma versão resumida do README** ideal para exibir no GitHub, destacando apenas o Swagger e exemplos rápidos de uso. Isso deixa mais limpo e direto. Quer que eu faça?
```
