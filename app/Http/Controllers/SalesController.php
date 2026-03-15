<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseRequest;

class SalesController extends Controller
{
    public function purchase(PurchaseRequest $request)
    {
        // 1. 送られてきた商品IDを取得
        $product_id = $request->get('product_id');
        $product = Product::find($product_id);

        // 在庫切れチェックは「ビジネスロジック」なので、ここに残してOKです！
        if ($product->stock <= 0) {
            return response()->json(['message' => '商品が在庫切れです'], 400);
        }

        // 3. データベースの更新処理（売上追加 ＋ 在庫減算）
        // どちらか片方だけ失敗すると困るので「トランザクション」を使うのがプロ！
        DB::beginTransaction();
        try {
            // 売上レコードを作成
            $sale = new Sale();
            $sale->product_id = $product_id;
            $sale->save();

            // 在庫を1つ減らす
            $product->decrement('stock');

            DB::commit(); // 全部うまくいったら確定！
            return response()->json(['message' => '購入成功！在庫を減らしました。']);

        } catch (\Exception $e) {
            DB::rollBack(); // 何かエラーが起きたら元に戻す！
            return response()->json(['message' => '購入処理に失敗しました'], 500);
        }
    }
}