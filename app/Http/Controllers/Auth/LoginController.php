<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/list'; // あなたの商品一覧のURL（routeのパス）に変更

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }




    /**
     * ユーザーがログアウトした後の処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        // ログアウトしたらログイン画面（routeのlogin）へリダイレクトする
        return redirect()->route('login');
    }



    /**
    * ログイン失敗時のエラーメッセージを定義する
    */
    protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            // ここに日本語メッセージを書く！
            $this->username() => ['メールアドレスまたはパスワードが正しくありません。'],
        ]);
    }




    
    /*ログイン画面で未入力だった時のエラーメッセージ*/
    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            // ✅ ここに日本語メッセージを書く！
            $this->username() . '.required' => 'メールアドレスを入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ]);
    }









}