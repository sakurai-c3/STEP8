@extends('layouts.app') @section('content') <div class="container">

@section('title', '商品情報編集')

    <h1>商品編集画面</h1>


    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif



    <div>
        <p>商品情報ID: {{ $product->id }}</p>
    </div>


    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form-group">
            <label class="required-label">商品名</label>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name ?? '') }}">
    
            @if($errors->has('product_name'))
                <p style="color: red;">{{ $errors->first('product_name') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="required-label">メーカー</label>
            <select name="company_id" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('company_id'))
                <p style="color: red;">{{ $errors->first('company_id') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="required-label">価格</label>
            <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}">
            @if($errors->has('price'))
                <p style="color: red;">{{ $errors->first('price') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="required-label">在庫数</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}">
            @if($errors->has('stock'))
                <p style="color: red;">{{ $errors->first('stock') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label>コメント</label>
            <textarea name="comment">{{ $product->comment }}</textarea>
        </div>

        <div class="form-group">
            <label>商品画像</label>
            <input type="file" name="img_path">
            <p>現在の画像: {{ $product->img_path }}</p>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('product.show', $product->id) }}" class="btn">戻る</a>
    </form>
</div>
@endsection
