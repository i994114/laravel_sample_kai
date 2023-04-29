@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() === 'register')
                        ご登録いただいたアドレスに認証メールを送りました。
                        メールをご確認いただき、メール内の認証ボタンを押してください。
                    @else
                        ログインしました！
                        <a href="{{route('drills.mypage')}}">こちらから</a>マイページに移動できます。
                    @endif

                </div>
                <div class="card-body">
                    @if (request()->path() === 'register')
                        ご登録いただいたアドレスに認証メールを送りました。
                        メールをご確認いただき、メール内の認証ボタンを押してください。
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
