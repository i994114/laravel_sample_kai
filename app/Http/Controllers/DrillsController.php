<?php

namespace App\Http\Controllers;

use App\Drill;
use Illuminate\Http\Request;
use App\Http\Requests\SampleRequest;

class DrillsController extends Controller
{
    public function new() {
        return view('drills.new');
    }

    public function create(SampleRequest $request) {
        //モデルを使ってDBに登録する値をセット
        $drill = new Drill;
        
        //fillを使って一気に入れる
        $drill->fill($request->all())->save();

        //リダイレクトする。その際にフラッシュメッセージを入れる
        return redirect('/drills/new')->with('flash_message', _('Registered.'));

    }
}
