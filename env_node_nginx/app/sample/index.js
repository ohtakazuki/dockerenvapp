// モジュールの読込
const express = require('express');
const app = express();
const mongoose = require('mongoose');
const moment = require('moment');
// スキーマ定義の読込
const Book = require('./book_model.js')

// viewエンジンにejsを設定
app.set("view engine", "ejs");
app.set('views', './views');

// データベースへの接続文字列 (Docker Composeのサービス名 'db' を使用)
const dbUrl = `mongodb://user1:user1@db:27017/mongo?authSource=mongo`;

mongoose.connect(dbUrl)
  .then(() => {
    console.log('Connected to database.');
  }).catch((err) => {
    console.error('Failed to connect to database:', err);
    process.exit(1);
  });

// ルートパスへのGETリクエスト
app.get('/', async (req, res, next) => {
  try {
    let books = await Book.find();
    console.log('booksの件数:', books.length);

    const formattedBooks = books.map(book => {
      const formattedDate = book.insert_timestamp
        ? moment(book.insert_timestamp).format('YYYY-MM-DD HH:mm:ss')
        : 'N/A';
      return {
        id: book.id || book._id.toHexString(),
        title: book.title,
        date: formattedDate
      };
    });
    res.render("index", { books: formattedBooks });
  } catch (err) {
    console.error('Failed to fetch books:', err);
    next(err); // エラーハンドリングミドルウェアへ渡す
  }
});

// ポート3000で待受 (コンテナ内部ポート)
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Listening on internal port ${PORT}. Access via Nginx (http://localhost/).`);
});

// 基本的なエラーハンドリングミドルウェア
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).send('Something broke!');
});
