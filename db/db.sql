CREATE TABLE preferencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo_landing_page VARCHAR(255),
    favicon VARCHAR(255),
    logo_cabecalho VARCHAR(255),
    link_facebook VARCHAR(255),
    link_instagram VARCHAR(255),

    titulo_secao_home VARCHAR(255),
    subtitulo_secao_home VARCHAR(255),
    imagem_secao_home VARCHAR(255),
    titulo_caracteristicas_home VARCHAR(255),

    titulo_secao_testemunho VARCHAR(255),

    titulo_secao_loja_apps VARCHAR(255),
    subtitulo_secao_loja_apps VARCHAR(255),
    imagem_secao_loja_apps VARCHAR(255),
    link_playtore VARCHAR(255),
    link_appstore VARCHAR(255),
    imagem_appstore VARCHAR(255),
    imagem_playstore VARCHAR(255),

    telefone_contato VARCHAR(50),

    logo_rodape VARCHAR(255),
    mensagem_copyright VARCHAR(255),
    url_rodape VARCHAR(255),
    mensagem_powered VARCHAR(255)
);

CREATE TABLE usuarios (
    codigo_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE caracteristicas_home (
    codigo_caracteristica INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255),
    descricao TEXT
);

CREATE TABLE testemunhos (
    codigo_testemunho INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    funcao VARCHAR(255),
    titulo VARCHAR(255),
    descricao TEXT,
    foto VARCHAR(255),
    imagem_fundo VARCHAR(255)
);

CREATE TABLE contatos (
    codigo_mensagem INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    telefone VARCHAR(50),
    mensagem TEXT,
    data DATETIME DEFAULT CURRENT_TIMESTAMP
);
