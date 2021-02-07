// モジュールの読込
const express = require('express');
const app = express();
const mongoose = require('mongoose');
const moment = require('moment');
// スキーマ定義
const Book = require('./book_model.js')

// viewエンジンにejsを設定
app.set("view engine", "ejs");

// 直下のリクエストに対する記述
app.get('/', function(req, res) {
  mongoose.connect('mongodb://node2_db/mongo?authSource=mongo', {
    user: 'user1',
    pass: 'user1',
    useNewUrlParser: true,
    useUnifiedTopology: true,
    useFindAndModify: false,
    useCreateIndex: true
  });

  Book.find({}, function (err, books) {
    mongoose.connection.close();
    console.log('booksの件数:', books.length);
    res.render("index", {books: books, moment: moment});
  });
});

app.listen(3000, function() {
  console.log('Listening on port 3000.');
});