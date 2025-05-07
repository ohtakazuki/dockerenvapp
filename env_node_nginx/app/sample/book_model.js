const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const bookSchema = new Schema({
  title: String,
  insert_timestamp: { type: Date, default: Date.now }
}, {
  versionKey: false, // __v フィールドを非表示に
  toJSON: { virtuals: true }, // toJSON時に仮想フィールドを含める
  toObject: { virtuals: true } // toObject時に仮想フィールドを含める
});

// 仮想フィールド 'id' を定義 (_id の文字列版)
bookSchema.virtual('id').get(function(){
    return this._id.toHexString();
});

// 'Book' モデルを 'books' コレクションに紐付けてエクスポート
module.exports = mongoose.model('Book', bookSchema, 'books');