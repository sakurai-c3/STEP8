@extends('layouts.app') @section('content') <div class="container">

@section('title', '新規登録')

    <title>商品新規登録</title>
</head>
<body>
    <h1>商品新規登録画面</h1>



    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif



    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" novalidate>
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
                <option value="">メーカーを選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            @if($errors->has('company_id'))
                <p style="color: red;">{{ $errors->first('company_id') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="required-label">価格</label>
            <input type="number" name="price" required>
            @if($errors->has('price'))
                <p style="color: red;">{{ $errors->first('price') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="required-label">在庫数</label>
            <input type="number" name="stock" required>
            @if($errors->has('stock'))
                <p style="color: red;">{{ $errors->first('stock') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label>コメント</label>
            <textarea name="comment"></textarea>
        </div>

        <div class="form-group">
            <label>商品画像</label>
            <input type="file" name="img_path">
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
        <a href="{{ route('product.list') }}" class="btn">戻る</a>
    </form>
</div>
@endsection