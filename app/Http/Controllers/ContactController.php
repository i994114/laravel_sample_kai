<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //コンタクトフォームを表示
    public function index() {
        return view('contact.index');
    }

    //メールの自動送信設定
    public function send(Request $request) {
        Mail::send('email.text', [], function($data) {
            $data->to('0513kaz0513kaz@gmail.com')->subject('mail dummy');
        });

        //送信完了を表示
        return back()->withInput($request->only(['name']))
                     ->with('sent', '送信完了しました');
    }
}
