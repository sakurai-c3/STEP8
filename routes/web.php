<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; // 【追加】1. コントローラーを呼び出す



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 1. トップページ（元からあるもの）
Route::get('/', function () {
    return view('welcome');
});

// 2. ログイン機能（元からあるもの）
Auth::routes();

// 3. ホーム画面（元からあるもの）
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 4. 【追加】商品一覧画面  ルート名規約：小文字ドット区切り
    // 2. 商品一覧画面へのルート設定
Route::get('/list', [ProductController::class, 'showList'])->name('product.list');

// 削除処理の窓口（ルート）
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

// 1.新規登録の窓口（新規登録画面を表示する（GET））
Route::get('/products/new', [ProductController::class, 'showCreate'])->name('product.new');

// 2. フォームから届いたデータを保存する（POST） ←これを追加！
Route::post('/products/new', [ProductController::class, 'store'])->name('product.store');

// 商品詳細画面を表示するルート
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

// 1. 編集画面を表示する（GET）
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');

// 2. 編集内容を保存（更新）する（PUT または POST）
// ※今回は分かりやすく POST（または Laravel流の PUT）を使いますが、まずは窓口だけ！
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('product.update');