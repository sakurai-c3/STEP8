/* public/js/confirmation.js */

// 画面が読み込まれたら実行する
document.addEventListener('DOMContentLoaded', function () {
    
    // 「delete-form」というクラスがついた全てのフォームを探す
    const deleteForms = document.querySelectorAll('.delete-form');

    // 見つかったフォーム一つひとつに「送信時の確認」を設定する
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            // 確認ダイアログを出して、「キャンセル」されたら送信を止める
            if (!confirm('本当に削除しますか？')) {
                event.preventDefault();
            }
        });
    });




    // type="email" の入力欄をすべて取得
    const emailInputs = document.querySelectorAll('input[type="email"]');

    emailInputs.forEach(input => {
        // 入力された瞬間に実行される
        input.addEventListener('input', function() {
            // 全角英数字を半角に変換、それ以外の全角文字は削除
            this.value = this.value.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
                return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
            }).replace(/[^ -~]/g, ""); // 半角英数記号以外（日本語など）を消す
        });
    });



});