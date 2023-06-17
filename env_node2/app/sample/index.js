// モジュールの読込
const express = require('express');
const app = express();
const mongoose = require('mongoose');
const moment = require('moment');
// スキーマ定義
const Book = require('./book_model.js')

// viewエンジンにejsを設定
app.set("view engine", "ejs");

// データベースへの接続
mongoose.connect('mongodb://node2-db/mongo?authSource=mongo', {
  user: 'user1',
  pass: 'user1'
}).then(() => {
  console.log('Connected to database.');
}).catch((err) => {
  console.error('Failed to connect to database:', err);
});

// 直下のリクエストに対する記述
app.get('/', async function (req, res) {
  try {
    let books = await Book.find();
    console.log('booksの件数:', books.length);

    // フォーマット処理後のデータを渡す
    books = books.map(book => {
      book.date = moment(book.insert_timestamp).format('YYYY-MM-DD HH:mm:ss');
      return book;
    });
    res.render("index", { books: books });
  } catch (err) {
    console.error('Failed to fetch books:', err);
    res.status(500).send('Server error.');
  }
});

app.listen(3000, function () {
  console.log('Listening on port 3000.');
});
