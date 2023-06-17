const mongoose = require('mongoose');
const Schema = mongoose.Schema;
const ObjectId = Schema.ObjectId;

const bookSchema = new Schema({
  id: ObjectId,
  title: String,
  insert_timestamp: Date
});

module.exports = mongoose.model('books', bookSchema);
