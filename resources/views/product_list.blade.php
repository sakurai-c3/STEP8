@extends('layouts.app') 

@section('title', '商品一覧')

@section('content') 
<div class="container">

    <h1>商品一覧画面</h1>



    <div class="search-form">
        <form action="{{ route('product.list') }}" method="GET" id="search-form">
            <input type="text" name="search" placeholder="検索キーワード" value="{{ request('search') }}">

            <select name="company_id">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>

            <input type="number" name="min_price" placeholder="最小価格"> 〜 
            <input type="number" name="max_price" placeholder="最大価格">

            <input type="number" name="min_stock" placeholder="最小在庫"> 〜 
            <input type="number" name="max_stock" placeholder="最大在庫">


            <button type="submit" id="search-button" class="btn btn-primary">検索</button>
    
        </form>
    </div>

    {{-- tableに class="product-table" を追加 --}}
    <table class="product-table" id="product-table">
        <thead>
            <tr>
                {{-- 各列に幅指定用のクラスを付ける --}}
                <th class="col-id sort" data-sort="id">ID</th>
                <th class="col-name sort" data-sort="product_name">商品名</th>
                <th class="col-price sort" data-sort="price">価格</th>
                <th class="col-stock sort" data-sort="stock">在庫数</th>
                <th class="col-company sort" data-sort="company_id">メーカー名</th>
                <th class="col-action">
                        <a href="{{ route('product.new') }}" class="btn btn-secondary">新規登録</a>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr id="product-row-{{ $product->id }}"> {{-- 行全体にIDをつける --}}
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}円</td>
                    <td>{{ $product->stock }}個</td>
                    <td>{{ $product->company->company_name }}</td> 
                    <td> 
                        <div class="action-buttons">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">詳細</a>

                            {{-- formタグは削除し、buttonタグだけにします。jsで制御するため class="btn-delete" と data-id を追加 --}}
                            <button type="button" class="btn btn-delete" data-id="{{ $product->id }}">削除</button>
                            
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($products->isEmpty())
        <p>商品が登録されていません。</p>
    @endif
</div>
@endsection