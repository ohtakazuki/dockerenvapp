package main

import (
  "time"
  "log"
  "gorm.io/gorm"
  "gorm.io/driver/mysql"
  "net/http"
  "github.com/gin-gonic/gin"
)

// 構造体の定義
type Books struct {
  Id int `gorm:"column:id"`
  Title string `gorm:"column:title"`
  InsertTimestamp *time.Time `gorm:"column:insert_timestamp"`
}

func main() {
  // DBへ接続
  dsn := "my:my@tcp(go1_db:3306)/my?charset=utf8mb4&parseTime=True&loc=Local"
  db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
  if err != nil {
    panic(err)
  }
  // 使い終わったらDB接続を閉じる
  mydb, err := db.DB()
  defer mydb.Close()
    
  // データを格納する変数を定義
  books := []Books{}

  // booksテーブルのレコードを全て取得
  db.Find(&books)

  // Ginの準備
  router := gin.Default()
  // テンプレートフォルダを指定
  router.LoadHTMLGlob("templates/*")

  // リクエストに対する応答を定義
  router.GET("/", func(c *gin.Context){
    c.HTML(http.StatusOK, "index.html", gin.H{"books": books})
    // ログに出力
    log.Println("アクセスがありました。booksのレコード数:", len(books))
  })

  // 接続待ち
  router.Run()
}