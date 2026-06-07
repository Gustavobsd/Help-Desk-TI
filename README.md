# Service Desk PHP

## Visão Geral

Este projeto é um sistema de Service Desk desenvolvido em PHP com suporte a usuários e administradores. Ele permite cadastro de usuários, login, abertura e acompanhamento de chamados, gerenciamento administrativo e um suporte via chatbot básico.

## Descrição do Projeto

- Nome do projeto: Help Desk TI
- Problema: Falta de controle e organização no atendimento de chamados técnicos.
- Solução: Sistema web para gerenciamento de chamados de TI.

## Objetivo

Fornecer uma central de atendimento que permita:

- cadastro e autenticação de usuários;
- abertura de chamados com categorias e prioridades;
- acompanhamento do status dos chamados;
- gerenciamento administrativo de chamados;
- exclusão de chamados concluídos;
- suporte inicial com respostas automáticas.

## Funcionalidades Principais

- Cadastro de usuário com validações básicas.
- Login de usuário com autenticação em banco de dados.
- Criação automática da tabela `chamados` quando o usuário acessa o dashboard.
- Abertura de chamados com título, categoria, prioridade e descrição.
- Dashboard de usuário com contagem de chamados por prioridade.
- Login e cadastro de administradores.
- Gerenciamento administrativo de chamados com alteração de status.
- Exclusão de chamados apenas quando o status estiver `concluido`.
- Chat de suporte com respostas automáticas para palavras-chave.

## Estrutura de Arquivos

- `config.php`
  - Configuração de conexão com o banco MySQL.
  - Define host, usuário, senha e nome do banco.
  - Ajusta charset para `utf8mb4`.

- `home.php`
  - Página inicial com acesso ao login, cadastro e área de suporte.

- `formulario.php`
  - Formulário de cadastro de novo usuário.
  - Envia dados para criação de conta.

- `login.php`
  - Tela de acesso do usuário comum.
  - Encaminha o formulário para `testLogin.php`.

- `testLogin.php`
  - Processa autenticação de usuários.
  - Verifica e-mail e senha hash.
  - Cria sessão e redireciona para `dashboard.php`.

- `dashboard.php`
  - Painel de usuário autenticado.
  - Permite abrir novos chamados.
  - Exibe chamados do usuário e métrica de prioridade.

- `logout.php`
  - Destrói a sessão e redireciona para página segura.

- `login_adm.php`
  - Tela de login para administradores.
  - Verifica credenciais em `administradores`.

- `cadastro_admin.php`
  - Formulário de cadastro de administrador.
  - Cria registros com senha hash.

- `fechamento_chamados.php`
  - Área administrativa para listar e atualizar chamados.
  - Permite alterar status e excluir chamados concluídos.

- `gestao.php`
  - Painel de gestão visual com navegação para as áreas do sistema.

- `protecao.php`
  - Página de proteção com senha adicional para acessar áreas internas.

- `suporte.php`
  - Chatbot simples que retorna mensagens baseadas em palavras-chave.

- `README.md`
  - Documentação principal do projeto.

- `DOCUMENTACAO_PROJETO.md`
  - Documentação operacional e descritiva do projeto.

## Fluxo de Uso

1. Acesse `home.php`.
2. Cadastre um usuário em `formulario.php`.
3. Faça login em `login.php`.
4. Abra chamados pelo painel `dashboard.php`.
5. Administrador faz login em `login_adm.php`.
6. Gerencie chamados em `fechamento_chamados.php`.
7. Consulte suporte via `suporte.php`.
8. Encerre a sessão com `logout.php`.

## Banco de Dados

### Conexão

A conexão está configurada em `config.php` com os seguintes dados:

- host: `localhost`
- usuário: `root`
- senha: `59797552`
- banco: `cadastro`

### Tabelas utilizadas

- `usuarios`
  - `id` INT AUTO_INCREMENT PRIMARY KEY
  - `nome` VARCHAR
  - `senha` VARCHAR
  - `email` VARCHAR
  - `telefone` VARCHAR
  - `genero` VARCHAR
  - `dataNascimento` DATE
  - `cidade` VARCHAR
  - `estado` VARCHAR
  - `endereco` VARCHAR

- `administradores`
  - `id` INT AUTO_INCREMENT PRIMARY KEY
  - `nome` VARCHAR
  - `email` VARCHAR
  - `senha` VARCHAR

- `chamados`
  - `id` INT AUTO_INCREMENT PRIMARY KEY
  - `usuario_id` INT
  - `titulo` VARCHAR(255)
  - `categoria` VARCHAR(100)
  - `prioridade` ENUM('baixa','media','alta')
  - `descricao` TEXT
  - `status` ENUM('aberto','em andamento','concluido')
  - `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP

A tabela `chamados` é criada automaticamente por `dashboard.php` caso não exista.

## Requisitos

- PHP 7.4 ou superior.
- Servidor web Apache ou Nginx.
- MySQL / MariaDB.
- Navegador moderno.

## Melhorias Recomendadas

- Adicionar proteção CSRF nos formulários.
- Criar validação e sanitização de dados mais robusta.
- Usar variáveis de ambiente para credenciais do banco.
- Implementar controle de acesso nas páginas administrativas.
- Usar `HTTPS` em produção.
- Criar layout responsivo completo.

## Segurança

- Senhas de usuários e administradores são armazenadas com `password_hash`.
- Autenticação usa `password_verify`.
- `logout.php` destrói a sessão antes de redirecionar.
- `protecao.php` usa senha fixa apenas como camada adicional e não deve ser usado como único mecanismo de proteção.

## Uso em Desenvolvimento

1. Coloque os arquivos na pasta do servidor web (`htdocs` no XAMPP).
2. Crie o banco `cadastro` no MySQL.
3. Ajuste `config.php` se necessário.
4. Acesse `home.php` pelo navegador.
5. Crie usuários e administradores para testar o fluxo.

## Observações

- O projeto não possui ainda um instalador automático de banco de dados.
- A tabela `chamados` é criada automaticamente, mas as tabelas `usuarios` e `administradores` devem existir antes do uso.
- O formulário de cadastro de administrador não exige autenticação adicional no código atual.

---

Obrigado por usar este projeto Service Desk em PHP. Se quiser, posso também gerar um script SQL inicial para criar as tabelas necessárias automaticamente.
