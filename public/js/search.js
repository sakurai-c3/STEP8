$(function() {
    // 1. 現在のソート状態を覚えておく変数（初期値）
    let sortColumn = 'id';
    let sortOrder = 'desc';

    // --- A. 検索ボタンが押されたときの監視 ---
    $('#search-button').on('click', function(event) {
        event.preventDefault();
        executeSearch(); // 検索実行
    });


    // --- B. ソート項目（th）が押されたときの監視 ---
    $(document).on('click', '.sort', function() {
        sortColumn = $(this).data('sort'); // どの列か取得
        
        // 昇順(asc)なら降順(desc)に、そうでなければ昇順にする（スイッチ切り替え）
        sortOrder = (sortOrder === 'asc') ? 'desc' : 'asc';
        
        executeSearch(); // ソート情報を反映して検索実行
    });


    // --- C. 共通の通信処理（ここが心臓部！） ---
    function executeSearch() {
        // 1. フォームに入力された値をまるごと取得する
        let formData = $('#search-form').serialize(); 
        // ※formに id="search-form" をつける必要があります！

        // ★ここを書き換え！手書きではなく、formタグのaction属性を読み取ります
        let url = $('#search-form').attr('action');

        // 2. Ajax通信を開始
        $.ajax({
            url: url, // 自動で取得したURLを使う
            type: 'GET',
            data: formData + '&sort=' + sortColumn + '&direction=' + sortOrder,   // 検索キーワードなどのデータ
            dataType: 'html', // 今回は「検索結果のHTML」をまるごと受け取る作戦にします
        })
        .done(function(data) {
            // 通信成功時の処理
            console.log('通信成功！');
            
            // ここで一覧表（テーブル）の中身を書き換える処理を後で書きます
            // 1. 届いたデータ（ページ丸ごと）の中から、#product-table の中身だけを抽出する
            let newTable = $(data).find('#product-table').html();

            // 2. 今の画面にある #product-table の中身を、新しいものにガバッと書き換える
            $('#product-table').html(newTable);
            
            console.log('画面を更新しました！');
        })
        .fail(function() {
            // 通信失敗時の処理
            alert('通信に失敗しました。');
        });
    }


    // --- 4. 削除処理の非同期化 ---

    // $(document).on を使うことで、検索後に新しく出たボタンにも反応させます
    $(document).on('click', '.btn-delete', function() {
        console.log('Ajaxの削除ボタンが押されたよ！'); // これを追加
        // ① 確認ダイアログを出す
        if (!confirm('本当に削除しますか？')) {
            return; // キャンセルならここで終わり
        }

        // ② 必要な情報を集める
        let productId = $(this).data('id'); // ボタンからIDを取得
        let clickBtn = $(this); // 押されたボタンを記憶しておく（後で消すため）

        // ③ Ajaxで削除リクエストを送る
        $.ajax({
            url: '/products/destroy/' + productId, // 送り先（Route名に合わせて調整）★ここがルート設定と合っているか重要
            type: 'POST',
            data: {
                '_method': 'DELETE', // Laravelで削除と認識させるおまじない
                '_token': $('meta[name="csrf-token"]').attr('content') // これが「合言葉」(CSRF)。<meta>タグから読み取っています
            }
        })
        .done(function(data) {
            // ④ 成功したら、そのボタンがある「行(tr)」を画面から消す
            // closest('tr') は「自分を包んでいる一番近い tr」を探す命令です
            clickBtn.closest('tr').fadeOut(300, function() {
                $(this).remove(); // 0.3秒かけてフワッと消えた後、HTMLから削除
            });
            console.log('削除成功！');
        })
        .fail(function() {
            alert('削除に失敗しました。');
        });
    });
});