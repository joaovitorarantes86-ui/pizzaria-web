# 🍕 Arantes Pizzaria - Sistema Web

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)

Sistema web completo para pizzaria com site institucional, cardápio dinâmico, pedidos online e painel administrativo.

---

## Funcionalidades

### Site (cliente)
- Página inicial com hero e promoções
- Cardápio com filtros por categoria e busca
- Formulário de pedido com validação front-end e back-end
- Formulário de contato
- Cadastro e login de usuários

### Painel Administrativo
- Dashboard com estatísticas em tempo real
- Gerenciamento de pedidos (alterar status)
- Gerenciamento do cardápio (CRUD completo)
- Mensagens de contato

---

## Como Rodar

### Pré-requisitos
- [XAMPP](https://www.apachefriends.org/) (Apache + PHP + MySQL)

### Passos

```bash
# 1. Copie o projeto para o htdocs
cp -r pizzaria-web /c/xampp/htdocs/pizzaria-web

# 2. Inicie Apache e MySQL no XAMPP

# 3. Importe o banco de dados
# Acesse http://localhost/phpmyadmin
# Crie um banco chamado "pizzaria"
# Importe database/banco.sql

# 4. Acesse
http://localhost/pizzaria-web
```

---

## Acessos

| Tipo | URL | E-mail | Senha |
|------|-----|--------|-------|
| Login Cliente | `/login.php` | joao@email.com | password |
| Painel Admin | `/admin/login.php` | admin@pizzaria.com | password |

---

## Estrutura

```
pizzaria-web/
├── admin/              Painel administrativo
├── CSS/                Estilos
├── database/           Script SQL
├── includes/           Header, footer, conexão
├── JS/                 Scripts front-end
├── process/            Processamento de formulários
├── uploads/            Imagens enviadas pelo admin
├── index.php           Página inicial
├── cardapio.php        Cardápio com filtros
├── pedidos.php         Formulário de pedido
├── contato.php         Formulário de contato
├── login.php           Login do cliente
├── cadastro.php        Cadastro de cliente
├── sobre.php           Sobre a pizzaria
└── README.md
```

---

## Tecnologias

- **PHP 7.4+** com PDO
- **MySQL 8.0**
- **HTML5 / CSS3** com design responsivo
- **JavaScript** puro (validação e interação)

