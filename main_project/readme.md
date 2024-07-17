# Sistema Web - Documentação

## 1. Introdução
### Visão Geral do Projeto
O sistema web de vendas foi desenvolvido para:

### Objetivos
- Facilitar a gestão de vendas de uma loja
- Prover um ambiente parcial entre vendedor cliente e gerente

### Tecnologias Utilizadas
- HTML5
- CSS3
- JavaScript
- PHP 8
- MySQL

## 2. Estrutura do Projeto
### Árvore de Diretórios

### Descrição dos Diretórios
- **css/**: Contém os arquivos de estilo.
- **js/**: Contém os arquivos JavaScript.
- **admin/**: Contém as paginas do admin.
- **produtos/**: Contém as paginas de cadastro de produto.
- **vendas/**: Contém as paginas de vendas.
- **clientes/**: Contém as paginas de clientes.
- **incluedes/**: Contém os scripts de configuração header,footer da pagina.


## 3. Instalação
### Requisitos
- Servidor Apache
- PHP 7+
- MySQL 8+

### Passos para Instalação
1. Instale e configure o servidor Apache.
2. Configure o banco de dados acessando o arquivo installer.php.

### Configuração
Edite o arquivo `db.php` e configure os parâmetros de conexão com o banco de dados.

...

## 4. Funcionamento do Sistema
### Fluxo de Navegação
- O usuário acessa a página inicial
- Em seguida, navega para administrar se no caso é um gerente, mas se é vendedor cabe ao gerente fornecer os tokens de acesso

### Funcionalidades
- **Cadastro de Vendedores**: Permite que o gerente cadastre novos vendedores.
- **Cadastro de Clientes**: Permite que o vendedor cadastre novos clientes.
- **Cadastro de produtos, categorias, fornecedores**: Permite que o gerente cadastre estes itens.
- **Autenticação**: Sistema de login do adminstrador, o password master será fornecido junto com o programa.

...

## 5. Componentes Frontend
### HTML
Os principais arquivos HTML estão localizados dentro de paginas com extenção PHP

### CSS
Utilizamos dois estilos:
- **css**: a pasta fica dentro da página admin que é para estilizar alguns componentes específicos do admin.
- **css**: a pasta fica no directório principal e serve para todo o sistema.

### JavaScript
Os scripts principais estão no directorio /js.

...

## 6. Componentes Backend
### Estrutura dos Arquivos PHP
Os principais arquivos PHP são:

- **index.php**: Ponto de entrada do sistema.
- **db.php**: Script de conexão com o banco de dados.
- **installer.php**: script que instala o sistema, configura a conexão com o banco de dados e cria o arquivo db.php.

### Fluxo de Dados
Os dados são enviados do frontend atravéz dos metodos post e get.

### Integrações
Integração com o serviço de icones do fontawesome.

...

## 7. Banco de Dados
### Modelo de Dados
-**Simples**;


## 8. API
### Endpoints
- **GET /api/users**: Retorna a lista de usuários.

### Autenticação
Utilizamos façanhas da variavel $_SESSION[] para autenticar os usuários

...


## 9. Manutenção e Atualizações
### Procedimentos de Atualização
Para atualizar o sistema contacte a equipe a 49Legacy.

### Melhores Práticas de Manutenção
- Monitorar o desempenho do sistema e os dados.

...

## 10. Anexos
### Referências
- [Documentação PHP](https://www.php.net/docs.php)
- [Documentação MySQL](https://dev.mysql.com/doc/)

### Créditos
- Mafudje Bá Jau

### Termos de Uso
Os termos de uso do sistema são:
- Page a licença antes de usar.

