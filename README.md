# Weather API Project

Este projeto é uma API simples em PHP para consulta de informações meteorológicas, com controle de acesso por IP e autenticação via token.

## Funcionalidades

- **Consulta de clima**: Endpoint `/weather` para obter informações meteorológicas.
- **Controle de IP**: Apenas IPs cadastrados podem acessar o endpoint `/weather`.
- **Cadastro de IP**: Endpoint `/subscribeIp` para cadastrar novos IPs autorizados (requer token de autenticação).
- **Variáveis de ambiente**: Utiliza arquivo `.env` para configuração de variáveis sensíveis.

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
   ```
2. Instale as dependências via Composer:
   ```sh
   composer install
   ```
3. Crie um arquivo `.env` na raiz do projeto com o seguinte conteúdo:
   ```env
   OAUTH_TOKEN=seu_token_aqui
   ```
4. (Opcional) Adicione IPs autorizados no arquivo `ips.json`:
   ```json
   ["127.0.0.1"]
   ```

## Como Usar

### 1. Consultar Clima
- **Endpoint:** `/weather`
- **Método:** `GET`
- **Requisito:** O IP do cliente deve estar cadastrado em `ips.json`.

### 2. Cadastrar Novo IP
- **Endpoint:** `/subscribeIp`
- **Método:** `POST`
- **Body:**
  - `token`: Token de autenticação definido no `.env`.
- **Exemplo:**
   ```sh
   curl -X POST -d "token=seu_token_aqui" http://localhost/subscribeIp
   ```

## Observações
- O projeto utiliza a biblioteca [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) para gerenciamento de variáveis de ambiente.
- Certifique-se de que o servidor web tenha permissão de escrita no arquivo `ips.json`.

## Licença
Este projeto está sob a licença MIT.
