<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drill;
use App\Problem;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SampleRequest;
use Illuminate\Support\Facades\Auth;

class DrillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drills.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //モデルを使ってDBに登録する値をセット
        $drill = new Drill;
        $problem = new Problem;

        //$requestに入るのは入力フォームの値のみ
        Log::debug($request);

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
        return redirect('/drills/create')->with('flash_message', _('Registered.'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
