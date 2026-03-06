<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // 商品モデルを呼び出す
use App\Models\Company; // 会社モデルを呼び出す
use App\Http\Requests\ProductRequest;



class ProductController extends Controller
{
    /**
     * 新しいコントローラインスタンスの生成
     *
     * @return void
     */
    public function __construct()
    {
        // このコントローラー内のすべての機能に「ログイン必須」の制限をかける
        $this->middleware('auth');
    }









    /**
     * 商品一覧画面を表示する
     */
    public function showList(Request $request) // メソッド名はローワーキャメル
        {


            // 1. まずは「商品の検索の準備」をする（まだ実行しない）
            $query = Product::query();

            // 2. もし検索窓にキーワード（search）が入っていたら
            if ($search = $request->search) {
                // 商品名にその文字が含まれている（部分一致）ものを絞り込む
                $query->where('product_name', 'LIKE', "%{$search}%");
            }

            // 3. もしメーカー（company_id）が選ばれていたら
            if ($company_id = $request->company_id) {
                // そのメーカーIDに一致するものを絞り込む
                $query->where('company_id', $company_id);
            }

            // 4. 最後に「絞り込まれた結果」を全部取ってくる！
            $products = $query->get();



        
            $companies = Company::all(); // メーカー一覧をDBから取ってくる（セレクトボックス用）
        
        

            // 2. product_list.blade.php を表示する。
            // その時、'products' という名前でデータ ($products) を渡す。
            return view('product_list', [
                'products' => $products ,
                'companies' => $companies,
                ]);
        }




    public function destroy($id) // 商品削除
    {
        // 1. 整理券（ID）を頼りに、消すべき商品を1つ見つける
        $product = Product::find($id);

        // 2. その商品を「削除（delete）」する
        $product->delete();

        // 3. 削除が終わったら、一覧画面にリダイレクト（戻る）
        return redirect()->route('product.list');
    }




    public function showCreate()  // 新規登録画面出す
    {
        // メーカーの一覧もセレクトボックスで選びたいので、全メーカーを取得しておく
        $companies = Company::all();

        // 'product_create' という名前のViewファイルを表示する
        // その時、メーカー一覧（$companies）を一緒に持っていく
        return view('product_create', [
            'companies' => $companies,
        ]);
    }




    public function store(ProductRequest $request) // 新規情報データ登録（保存）
    {

        /* レビュー後、ProductRequestに移動（updateメソッドと一緒になっている）
        // --- ここから門番（バリデーション）の仕事 ---
        $request->validate([
            'product_name' => 'required',
            'company_id'   => 'required', // メーカーID
            'price'        => 'required | integer',
            'stock'        => 'required | integer',
            'comment'      => 'nullable',
            'img_path'     => 'nullable | image',
        ], [
            // ここに「エラーメッセージ」を書くと、日本語で表示できます
            'product_name.required' => '商品名は必須項目です。',
            'company_id.required'   => 'メーカーを選択してください。',
            'price.required'        => '価格は必須項目です。',
            'price.integer'         => '価格は数値で入力してください。',
            'stock.required'        => '在庫数は必須項目です。',
            'stock.integer'         => '在庫数は数値で入力してください。',

        ]);

        // --- ここまで門番（バリデーション）の仕事 ---
        */




        // 1. 新しい「商品の空箱」を作る
        $product = new Product();

        // 2. フォームから届いた荷物（$request）を、箱に詰める
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->company_id = $request->company_id;
        $product->comment = $request->comment;

        // 3. 画像がある場合は、保存してパスを箱にメモする
        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        // 4. データベースに「保存（save）」する！
        $product->save();

        // 5. 自画面（新規登録画面）にリダイレクトする
        return redirect()->route('product.new')->with('status', '商品を新規登録しました。');
    }




    public function show($id) // 商品詳細情報
    {
        // 1. 整理券（$id）を使って、DBからその商品を1件だけ探し出す
        $product = Product::find($id);

        // 2. もし商品が見つからなければ、一覧画面に戻る（またはエラーにする）
        if (!$product) {
            return redirect()->route('product.list');
        }

        // 3. 見つけた商品（$product）を持って、詳細画面（product_detail）へ案内する
        return view('product_show', [
            'product' => $product,
        ]);
    }
        


        

    public function edit($id) // 商品情報編集画面
    {
        // 1. 整理券（$id）を使って、編集したい商品を1件探し出す
        $product = Product::find($id);

        // 2. メーカー一覧も選び直せるように、全部取得しておく
        $companies = Company::all();

        // 3. 商品とメーカー一覧を持って、編集画面（product_edit）へ！
        return view('product_edit', [
            'product' => $product,
            'companies' => $companies,
        ]);
    }




        

    public function update(ProductRequest $request, $id) // 商品情報更新
    {
        /* レビュー後、ProductRequestに移動（storeメソッドと一緒になっている）
        // --- ここから門番（バリデーション）の仕事 ---
        $request->validate([
            'product_name' => 'required',
            'company_id'   => 'required', // メーカーID
            'price'        => 'required | integer',
            'stock'        => 'required | integer',
            'comment'      => 'nullable',
            'img_path'     => 'nullable | image',
        ], [
            // ここに「エラーメッセージ」を書くと、日本語で表示できます           
            'product_name.required' => '商品名は必須項目です。',
            'company_id.required'   => 'メーカーを選択してください。',
            'price.required'        => '価格は必須項目です。',
            'price.integer'         => '価格は数値で入力してください。',
            'stock.required'        => '在庫数は必須項目です。',
            'stock.integer'         => '在庫数は数値で入力してください。',

        ]);

        // --- ここまで門番（バリデーション）の仕事 ---
        */


        // 1. 整理券（$id）を使って、書き換えたい「既存の箱」をDBから探し出す
        $product = Product::find($id);

        // 2. 届いた荷物（$request）で、箱の中身を上書き（詰め替え）する
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->company_id = $request->company_id;
        $product->comment = $request->comment;

        // 3. 画像が新しく送られてきた場合だけ、保存し直す
        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        // 4. 上書きされた箱をDBに保存（更新）する！
        $product->save();

        // 5. 終わったら詳細画面（または一覧）に戻る
        return redirect()->route('product.edit', $product->id)->with('status', '商品の更新が完了しました。');
    }




}