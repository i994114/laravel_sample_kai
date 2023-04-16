<?php

namespace App\Http\Controllers;

use App\Drill;
use App\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SampleRequest;
use Illuminate\Support\Facades\Auth;

class DrillsController extends Controller
{
    public function new() {
        return view('drills.new');
    }

    public function create(SampleRequest $request) {
        //モデルを使ってDBに登録する値をセット
        $drill = new Drill;
        $problem = new Problem;

        //$requestに入るのは入力フォームの値のみ
        //Log::debug($request);

        //drillテーブルの保存
        $drill->title = $request->title;
        $drill->category_name = $request->category_name;
        $user = Auth::user();
        $drill->user_id = $user['id'];
        $drill->save();

        //saveしたidを取得
        $last_insert_id = $drill->id;

        //いったん全てのデータを取得($requestをforeachでまわせなかったので)
        $all_data = $request->all();
        //Log::debug($all_data);

        //problemテーブルの保存
        foreach($all_data as $key => $value) {
            if (strpos($key, 'problem') !== false && $value !== null) {
                $problem->description = $value;
                $problem->drill_id = $last_insert_id;
                $problem->save();
                $problem = new Problem;//続けてDB登録したいのでインスタンスを生成し直す
            }
        }
        
        //リダイレクトする。その際にフラッシュメッセージを入れる
        return redirect('/drills/new')->with('flash_message', _('Registered.'));

    }

    public function index() {
        $drills = Drill::all();
        return view('drills.index', ['drills' => $drills]);
    }

    public function edit($id) {
        if (!ctype_digit($id)) {
            return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
        }

        $drill = Drill::find($id);
        $problem = Problem::where('drill_id', $id)->get()->pluck('description');

        //Log::debug($problem);
        
        return view('drills.edit', ['drill' => $drill, 'problem' => $problem]);
    }

    public function update(Request $request, $id) {
        if (!ctype_digit($id)) {
            return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));;
        }

        $drill = Drill::find($id);
        $drill->fill($request->all())->save();
        
        return redirect('/drills')->with('flash_message', __('Registered. '));
    }

    public function destroy($id) {
        if (!ctype_digit($id)) {
            return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
        }

        //まず外部キーをもつレコードから削除
        $problems = Problem::all()->where('drill_id', $id);
        foreach($problems as $problem) {
            $problem->delete();
        }
        //最後に大元のdrillを削除
        Drill::find($id)->delete();
        
        return redirect('/drills')->with('flash_message', __('Deleted.'));
    }

    public function show($id) {
        if (!ctype_digit($id)) {
            return redirect('drills')->with('flash_message', 'Invalid operation was performed.');
        }

        $drill = Drill::find($id);
        $problem = Problem::all()->where('drill_id', $id)->pluck('description');
        
        //Log::debug($problem);

        return view('drills/show', ['drill' => $drill, 'problem' => $problem]);
    }

    public function mypage()
    {
        $drills = Auth::user()->drills()->get();
        Log::debug($drills);
        return view('drills.mypage', compact('drills'));
    }
    
}
