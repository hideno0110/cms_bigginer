<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Role;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Photo;
use Session;
use File;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      $users = User::all();

      return view('admin.users.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $roles = Role::pluck('name', 'id')->all();

      return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request) // UserRequestモデルで入力制御を行う
    {

      if(trim($request->password) == '') {
        $input = $request->except('password');
      } else {
        //post requestを全て$input変数に配列にして格納
        $input = $request->all();
        
        //パスワードのbcrypt化（レインボー対策)
        $input['password'] = bcrypt($request->password);
      }

      //ファイルの保存
      if($file = $request->file('photo_id')) {
        $name = time(). $file->getClientOriginalName();
        $file->move('images', $name);
        //ここでPhotoクラスのインスタンス化とDBへの保存を行う
        $photo = Photo::create(['file'=>$name]);
        //インクリメントされたphoto DBのidを取得し、$input へ格納
        $input['photo_id'] = $photo->id;
        
      }
      //Userインスタンスを作成し、DBへ保存
      User::create($input);

      return redirect('/admin/users');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


      return view('admin.users.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::findOrFail($id);

     // $user = $user->photo->get();
    // dd($user->photo);

      $roles = Role::pluck('name', 'id');
      
     
      return view('admin.users.edit', compact('user', 'roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
      $user = User::findOrFail($id);
      
      if(trim($request->password) == '') {
        $input = $request->except('password');
      } else {
        $input = $request->all();
        //パスワードのbcrypt化（レインボー対策)
        $input['password'] = bcrypt($request->password);
      }

      if($file = $request->file('photo_id')) {
        $name = time(). $file->getClientOriginalName();
        $file->move('images', $name);
        $photo = Photo::create(['file'=>$name]);
        $input['photo_id'] = $photo->id;
      }
     
      $user->update($input);

      return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);

      File::delete(public_path() . $user->photo->file);
      // unlink(public_path() . $user->photo->file);
      $user->delete();

       Session::flash('deleted_user', 'deleted!');
      // return redirect('/admin/users')->with('deleted_user', 'delete');
      return redirect('/admin/users');
    }
}
