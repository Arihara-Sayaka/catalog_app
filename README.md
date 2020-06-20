# catalog_app App

//データベース、ユーザー、テーブル作成、データの初期セットアップSQL

CREATE DATABASE catalog_app;

CREATE USER ari identified by '6655';

GRANT ALL ON catalog_app.* to ari;


CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  email VARCHAR(32) NOT NULL,
  name VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
  UNIQUE idx_email(email)
);

CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  comment TEXT NOT NULL,
  user_id int NOT NULL,
  trimmings_id int NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE likescount (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id int NOT NULL,
  trimmings_id int NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE dogbreed (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  name VARCHAR(50) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
);

INSERT INTO dogbreed (name, created_at, updated_at) VALUES
  ('マルチーズ', now(), now()),
  ('ボーダーコリー', now(), now()),
  ('トイプードル', now(), now()),
  ('ポメラニアン', now(), now()),
  ('ミニチュワダックスフンド', now(), now()),
  ('シュナウザー', now(), now()),
  ('シェットランド・シープドック', now(), now()),
  ('ヨークシャテリア', now(), now()),
  ('パピヨン', now(), now());


CREATE TABLE trimmings (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  title VARCHAR(144) NOT NULL,
  dogbreed_id int NOT NULL,
  picture VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  likes_count int,
  created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL
);

INSERT INTO trimmings (title, dogbreed_id, picture, body, likes_count) VALUES
('もふもふカット',
'1',
'https://pumpkiiin.com/wp-content/uploads/2019/11/da90736c721e8c75534b2f412150c403_s-300x200.jpg',
'バリカンを使わずオールシザーで！ふわふわ長持ち',
'1'
);

INSERT INTO trimmings (title, dogbreed_id, picture, body, likes_count) VALUES
('子犬カット',
'1',
'4f2b8b75bc6ee3.49252513.jpg',
'耳の毛を短めに小顔子に若返りカット',
'0'
);

INSERT INTO trimmings (title, dogbreed_id, picture, body, likes_count) VALUES
('走りやすい！',
'2',
'o0600040014052152753.jpg',
'走りやすくするために足元スッキリ',
'0'
);

INSERT INTO trimmings (title, dogbreed_id, picture, body, likes_count) VALUES
('まんまる',
'3',
'poodle726a.jpg',
'鼻周り、耳、頭、トイプードルらしくまん丸く仕上げる人気カット',
'0'
);

INSERT INTO trimmings (title, dogbreed_id, picture, body, likes_count) VALUES
('ライオン風',
'4',
'AS20181026002853_comm.jpg',
'ポメラニアンの毛質を生かしたライオン風カット',
'0'
);

INSERT INTO trimmings (title, dogbreed_id, picture, body, likes_count) VALUES
('フォルムを重視して',
'4',
'AS20181026002853_comm.jpg',
'顔と身体を繋げたような丸いフォルムでフサフサにカット',
'0'
);

INSERT INTO trimmings (title, dogbreed_id, picture, body, likes_count) VALUES
('耳に注目',
'5',
'Cole123RF091100054.jpg',
'ミニチュワダックスフンドの多きな耳をより印象的に長めスタイルで',
'0'
);

