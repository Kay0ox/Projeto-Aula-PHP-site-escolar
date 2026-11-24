# Escola Holmes: sistema escolar em PHP e MySQL

Sistema web de uma escola fictícia (Faculdade Holmes), feito em PHP puro com MySQL na disciplina de desenvolvimento web (Ciência da Computação, UNIPÊ). O repositório tem duas versões: a primeira, mais simples, e a 2.0, com perfis de aluno, professor e administrador.

## Versão 2.0 (`sitephp/escola_Holmes - Versao2.0/`)

- **Login e cadastro** com senha criptografada (`password_hash`) e controle de sessão
- **Aluno:** vê as próprias notas e usa um chat com a turma
- **Professor:** cria e gerencia turmas e a lista de alunos de cada turma
- **Administrador:** cadastra, edita e exclui alunos
- Consultas com *prepared statements* (`mysqli`)

Banco de dados: `bd2`, criado pelo script `bd2 (1).sql` (tabelas `alunos`, `turmas`, `alunos_turmas` e `chat_mensagens`). O `bd2.sql` na raiz é um modelo anterior desse banco.

## Versão 1 (`sitephp/`)

Site institucional com as páginas Início, Quem somos e Contato. As mensagens enviadas pelo formulário de contato ficam salvas no banco. Tem também uma área administrativa com login, onde é possível ler as mensagens e fazer o CRUD de clientes.

Banco de dados: `bd1`, com as tabelas `cliente`, `contato` e `usuario`. O script dessa versão não está no repositório.

## Tecnologias

- PHP (mysqli)
- MySQL
- HTML, CSS e JavaScript

## Como rodar

1. Instale o [XAMPP](https://www.apachefriends.org/) (Apache + MySQL).
2. Copie a pasta `sitephp` para dentro de `xampp/htdocs/`.
3. No phpMyAdmin, crie um banco chamado `bd2` e importe o arquivo `sitephp/escola_Holmes - Versao2.0/bd2 (1).sql`.
4. Confira usuário e senha do banco em `includes/config.inc.php` (versão 2.0) ou `config.inc.php` (versão 1).
5. Acesse `http://localhost/sitephp/escola_Holmes%20-%20Versao2.0/` no navegador.

A documentação do sistema está em `Documentação_Sistema_Faculdade_holmes.docx`.

## Autor

**Kayo Victor Vilar Silva**: [LinkedIn](https://www.linkedin.com/in/kayo-victor-vilar-525205373/) · [GitHub](https://github.com/Kay0ox)
