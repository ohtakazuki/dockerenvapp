package main

import (
	"log"
	"net/http"
	"os"
	"time"

	"github.com/gin-gonic/gin"
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
	"gorm.io/gorm/logger"
)

// Book 構造体 (データベースの books テーブルに対応)
type Book struct {
	Id              int        `gorm:"column:id;primaryKey;autoIncrement"`
	Title           string     `gorm:"column:title;not null"`
	InsertTimestamp *time.Time `gorm:"column:insert_timestamp;default:CURRENT_TIMESTAMP"`
}

// TableName メソッドで GORM にテーブル名を明示的に伝える (任意)
func (Book) TableName() string {
	return "books"
}

func main() {
	// --- データベース接続 ---
	// 環境変数から接続情報を取得 (docker-compose.yml の .env 参照)
	user := os.Getenv("MYSQL_USER")
	password := os.Getenv("MYSQL_PASSWORD")
	dbName := os.Getenv("MYSQL_DATABASE")
	// compose.yml のサービス名 'db' をホスト名として使用
	host := "db"
	port := "3306"

	dsn := user + ":" + password + "@tcp(" + host + ":" + port + ")/" + dbName + "?charset=utf8mb4&parseTime=True&loc=Local"

	// GORMのロガー設定 (SQLログを出力)
	newLogger := logger.New(
		log.New(os.Stdout, "\r\n", log.LstdFlags), // io writer
		logger.Config{
			SlowThreshold: time.Second, // 遅いSQLの閾値
			LogLevel:      logger.Info, // ログレベル (Info, Warn, Error, Silent)
			Colorful:      true,        // カラーログ
		},
	)

	// データベースに接続
	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{
		Logger: newLogger, // 設定したロガーを使用
	})
	if err != nil {
		log.Fatalf("Failed to connect to database: %v", err) // panic の代わりに log.Fatalf を使用
	}

	// GORMによる自動マイグレーション (テーブルが存在しない場合作成) - 開発時には便利
	// db.AutoMigrate(&Book{}) // 初期化SQLで作成するので通常は不要

	// --- Gin ルーターの設定 ---
	router := gin.Default() // Logger と Recovery ミドルウェアを含むデフォルトルーター

	// HTML テンプレートの場所を指定
	router.LoadHTMLGlob("templates/*.html") // app/templates/*.html を参照

	// --- ルートハンドラの定義 ---
	// GET / : 書籍リストを表示
	router.GET("/", func(c *gin.Context) {
		var books []Book // データを格納するスライス

		// books テーブルから全レコードを取得 (作成日時順にソート)
		result := db.Order("insert_timestamp desc").Find(&books)
		if result.Error != nil {
			log.Printf("Error fetching books: %v", result.Error)
			c.HTML(http.StatusInternalServerError, "error.html", gin.H{"message": "データベースエラーが発生しました。"})
			return // エラーが発生したら処理を中断
		}

		// 取得したデータをテンプレートに渡して HTML をレンダリング
		c.HTML(http.StatusOK, "index.html", gin.H{
			"books": books,
		})

		log.Printf("Accessed /. Found %d books.", len(books))
	})

	// --- サーバーの起動 ---
	log.Println("Starting server on port 8080...")
	// router.Run() はデフォルトで :8080 で起動
	if err := router.Run(":8080"); err != nil {
		log.Fatalf("Failed to run server: %v", err)
	}
}