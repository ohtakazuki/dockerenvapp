<?php

namespace App\Http\Controllers;

use App\Models\Book; // モデルを use
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Log ファサードを use

class BookController extends Controller
{
    /**
     * 書籍一覧を表示するアクション。
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // books テーブルのレコードを全て取得
        $data = [
            'books' => Book::all()
        ];

        // ログ出力 (デバッグレベル)
        Log::debug('BookController::index called. Data retrieved:', ['book_count' => count($data['books'])]);
        // 必要であればデータ内容もログに出力
        // Log::debug($data);

        // ビューにデータを渡して表示
        return view('book.index', $data);
    }
}