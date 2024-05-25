CREATE DATABASE crafter;
USE crafter;

-- Criar a Tabela dos Usuários
CREATE TABLE UserAccount (
    Email VARCHAR(64) PRIMARY KEY,
    Username VARCHAR(32) UNIQUE,
    Password VARCHAR(50),
    Perms INT(1)
);

-- Criar Tabela dos Jogos
CREATE TABLE Game (
    Title VARCHAR(29) PRIMARY KEY,
    Description TEXT,
    Devs VARCHAR(50),
    Publish DATE
);

-- Criar Tabela dos Comentários
CREATE TABLE Comment (
    CommentID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(32) UNIQUE,
    Title VARCHAR(29),
    Content TEXT,
    Date DATETIME,
    FOREIGN KEY (Username) REFERENCES UserAccount(Username),
    FOREIGN KEY (Title) REFERENCES Game(Title)
);


INSERT INTO Game (Title,Description,Devs,Publish)
VALUES ('The Crafter', 'Embarca numa jornada repleta de perigos, 
onde terás de usar a tua inteligência para sobreviver numa vida selvagem hostil e condições imprevisíveis.
À medida que te aventuras no coração destes terrenos impiedosos, 
enfrentarás uma legião de monstros que testarão as tuas habilidades 
de sobrevivência ao máximo. Cada decisão que tomares pode significar a 
diferença entre a vida e a morte.
Mas sobreviver não se trata apenas de manter-se vivo - é sobre prosperar 
contra todas as probabilidades. Forje mais armas para aumentar suas chances 
de sucesso e confie na tua astúcia e força.',"Didi", 2009-09-09-12-31 );

INSERT INTO Game (Title,Description,Devs,Publish)
VALUES ('Apolo', 'Desprezado pela sua família por não se 
revelar um bom arqueiro, ele escolheu embarcar numa aventura 
pelo mundo, determinado a derrotar os quatro grandes dragões. 
Enfrentando uma série de desafios ao longo do percurso, 
ele arriscou a própria vida para conquistar o reconhecimento como o 
melhor arqueiro do mundo.', "Hugo & Leandro", 2009-09-09-12-31 );

INSERT INTO Game (Title,Description,Devs,Publish)
VALUES ('Exo Invaders', '"Exo Invaders" é uma reinterpretação 
moderna do clássico "Space Invaders". 
Nele, os jogadores enfrentam ondas de invasores 
alienígenas enquanto tentam proteger a Terra. 
Com gráficos atualizados e possivelmente uma jogabilidade mais complexa, 
o jogo mantém a essência do original: atirar nos invasores antes que eles alcancem o solo',
 "Daniel & Gustavo", 2009-09-09-12-31 );

 INSERT INTO Game (Title,Description,Devs,Publish)
VALUES ('Run, RX3!', 'Bem-vind@ ao Futuro! 
Estamos em 2045 e, em breve, o melhor aliado do Homem será RX3! 
A empresa TechFuture lança-te um desafio: treinares infinitamente o seu mais recente robô: RX3.
Este modelo está a ser desenvolvido para ser o primeiro a chegar a locais de emergência. 
A agilidade e a atenção são, como tal, fatores essenciais! 
A tua missão é, portanto, melhorares o desempenho de RX3, na corrida de obstáculos. 
Aceita o desafio, seguindo as instruções da tela inicial, e torna-te parte do Futuro!',
 "Madalena", 2009-09-09-12-31 );

 INSERT INTO Game (Title,Description,Devs,Publish)
VALUES ("Soldier's Redemption", 'Num cenário pós-guerra devastado pela traição, 
o jogador assume o papel de Erwin Maurice, um soldado solitário determinado 
a desmascarar e punir o traidor que uma vez liderou seu esquadrão. 
Navegando por paisagens cheias de inimigos e enfrentando os perigos da 
batalha, o jogador mergulha numa busca implacável pela verdade e justiça. 
Cada decisão molda o destino do soldado, levando-o mais perto da redenção 
ou da ruína total.',
 "Raul & Miguel", 2009-09-09-12-31 );

