@extends('layouts.app') 

@section('title', '商品一覧')

@section('content') 
<div class="container">

    <h1>商品一覧画面</h1>



    <div class="search-form">
        <form action="{{ route('product.list') }}" method="GET">
            <input type="text" name="search" placeholder="検索キーワード" value="{{ request('search') }}">

            <select name="company_id">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>

    {{-- tableに class="product-table" を追加 --}}
    <table class="product-table">
        <thead>
            <tr>
                {{-- 各列に幅指定用のクラスを付ける --}}
                <th class="col-id">ID</th>
                <th class="col-name">商品名</th>
                <th class="col-price">価格</th>
                <th class="col-stock">在庫数</th>
                <th class="col-company">メーカー名</th>
                <th class="col-action">
                        <a href="{{ route('product.new') }}" class="btn btn-secondary">新規登録</a>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}円</td>
                    <td>{{ $product->stock }}個</td>
                    <td>{{ $product->company->company_name }}</td> 
                    <td> 
                        <div class="action-buttons">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">詳細</a>

                        
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn">削除</button>                          
                            </form>
                            
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