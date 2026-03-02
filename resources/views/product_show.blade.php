@extends('layouts.app') @section('content') <div class="container">

@section('title', '商品詳細')

    <h1>商品詳細画面</h1>

    <div>
        <div class="form-group">
            <label>商品情報ID</label>
            <span class="form-text">{{ $product->id }}</span>
        </div>
        
         <div class="form-group">
            <label>商品画像</label>
            <div class="form-text">
                @if($product->img_path)
                    <img src="{{ asset($product->img_path) }}" alt="商品画像" style="width: 200px;">
                @else
                    <span>画像はありません<span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label>商品名</label>
            <span class="form-text">{{ $product->product_name }}</span>
        </div>


        <div class="form-group">            
            <label>メーカー</label>
            <span class="form-text">{{ $product->company->company_name }}</span>
        </div>


        <div class="form-group">
            <label>価格</label>
            <span class="form-text">{{ $product->price }}円</span>
        </div>

        
        <div class="form-group">            
            <label>在庫数</label>
            <span class="form-text">{{ $product->stock }}個</span>
        </div>


        <div class="form-group">
            <label>コメント</label>
            <span class="form-text">{{ $product->comment }}</span>
        </div>
    </div>

    
    <div style="margin-top: 20px;">
        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">編集</a>

        <a href="{{ route('product.list') }}" class="btn">戻る</a>
    </div>

</div>
@endsection