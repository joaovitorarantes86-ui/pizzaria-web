CREATE DATABASE IF NOT EXISTS pizzaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pizzaria;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    tipo ENUM('cliente', 'admin') DEFAULT 'cliente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    rua VARCHAR(200) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    cep VARCHAR(10) NOT NULL,
    complemento VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cardapio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    ativo TINYINT(1) DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nome_cliente VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    pizza VARCHAR(100) NOT NULL,
    tamanho VARCHAR(50) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    cep VARCHAR(10) NOT NULL,
    pagamento VARCHAR(50) NOT NULL,
    observacoes TEXT,
    status ENUM('pendente', 'confirmado', 'entregue', 'cancelado') DEFAULT 'pendente',
    total DECIMAL(10,2),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS mensagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(20),
    assunto VARCHAR(100) NOT NULL,
    mensagem TEXT NOT NULL,
    lida TINYINT(1) DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- usuarios padrao (senha: password)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Admin', 'admin@pizzaria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('João Arantes', 'joao@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente');

-- cardapio inicial
INSERT INTO cardapio (nome, descricao, preco, imagem) VALUES
('Margherita', 'Molho de tomate fresco, mussarela de búfala e manjericão. O clássico italiano.', 42.90, 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=600'),
('Carne Seca', 'Carne seca desfiada, catupiry, cebola caramelizada e azeitonas pretas.', 54.90, 'https://images.unsplash.com/photo-1590947132387-155cc02f3212?w=600'),
('Frango com Requeijão', 'Frango temperado, requeijão cremoso, milho e orégano fresquinho.', 48.90, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=600'),
('Alho e Óleo', 'Azeite extra virgem, alho dourado, parmesão e salsinha. Simples e irresistível.', 38.90, 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600'),
('Chocolate c/ Morango', 'Creme de chocolate belga, morangos frescos e granulado. A sobremesa perfeita.', 46.90, 'https://images.unsplash.com/photo-1571407970349-bc81e7e96d47?w=600'),
('Calabresa Especial', 'Calabresa artesanal fatiada, cebola roxa, mussarela e pimenta verde.', 44.90, 'https://images.unsplash.com/photo-1593560708920-61dd98c46a4e?w=600');