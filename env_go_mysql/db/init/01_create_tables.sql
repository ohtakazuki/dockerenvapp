-- books テーブルを作成
CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  title VARCHAR(255) NOT NULL, -- 長さを指定し、NOT NULL制約を追加
  insert_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP -- デフォルト値を設定
);
