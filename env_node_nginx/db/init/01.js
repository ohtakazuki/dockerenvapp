// ユーザの作成
var user = {
  user: "user1",
  pwd: "user1",
  roles: [
    {
      role: "readWrite",
      db: "mongo" // .envで指定したデータベース名
    }
  ]
};
db.createUser(user);

// コレクションにデータを登録
db.books.insert({id: 1, title: 'プログラミング言語C', "insert_timestamp": new Date()});
db.books.insert({id: 2, title: 'やさしいコンピューター科学', "insert_timestamp": new Date()});
db.books.insert({id: 3, title: 'ゲーデル、エッシャー、バッハ―あるいは不思議の環', "insert_timestamp": new Date()});
db.books.insert({id: 4, title: 'TeXブック コンピュータによる組版システム', "insert_timestamp": new Date()});
db.books.insert({id: 5, title: '人月の神話 狼人間を撃つ銀の弾はない', "insert_timestamp": new Date()});