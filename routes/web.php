<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', function () {
    return redirect('/home/def');
});

Route::post('/user_select', function (Request $request) {
    if ((auth()->user()->roles()->first()->name=='manager')||(auth()->user()->roles()->first()->name=='loader')){
        return redirect('/user_rout_select/'.$request->userselect);
    }
    else return redirect('/user_rout_select/'.auth()->user()->id);
})->middleware('auth');;

Route::match(array('GET', 'POST'),'/user_rout_select/{id}', function ($id) {
    $cities = \App\City::orderBy('name', 'asc')->get();
    $users = \App\User::orderBy('name', 'asc')->get();
    $problems=\App\Problem::orderBy('created_at', 'desc')->get();
    $role_driver = \App\Role::where('name', 'driver')->first();
    $drivers=$role_driver->users;
    $user = \App\User::where('id', $id)->first();
    $rid=array();
    if(isset($user->routs)):
        $routs = $user->routs;
        foreach ($routs as $rout) {
            if(!in_array($rout->ident, $rid)){
                array_push($rid, $rout->ident);
            }
        }
    else:
        $routs = array();
    endif;

    $roles = \App\Role::orderBy('description', 'asc')->get();

    return view('home', [
        'cities' =>$cities,
        'users' => $users,
        'roles' => $roles,
        'routs' => $routs,
        'problems' => $problems,
        'drivers' => $drivers,
        'tab' => 'routs',
        'select' => $user,
        'rid'=>$rid
    ]);
    return redirect('/home/routs');
})->middleware('auth');;

Route::get('/home/{tab}', function ($tab) {
    $cities = \App\City::orderBy('name', 'asc')->get();
    $users = \App\User::orderBy('name', 'asc')->get();
    $problems=\App\Problem::orderBy('created_at', 'desc')->get();
    $role_driver = \App\Role::where('name', 'driver')->first();
    $drivers=$role_driver->users;
    $firstuser = $drivers->first();
    $roles = \App\Role::orderBy('description', 'asc')->get();
    $rid=array();
    if(isset($firstuser->routs)):
        $routs = $firstuser->routs;
        foreach ($routs as $rout) {
            if(!in_array($rout->ident, $rid)){
                array_push($rid, $rout->ident);
            }
        }
    else:
        $routs = array();
    endif;
    return view('home', [
        'cities' =>$cities,
        'users' => $users,
        'roles' => $roles,
        'routs' => $routs,
        'problems' => $problems,
        'drivers' => $drivers,
        'tab' => $tab,
        'select' => $firstuser
    ]);
})->middleware('auth');

Route::post('/update_user', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255'
    ]);

    $user=auth()->user();
    $mobile1=$user->mobiles()->first();
    if ($user->name!=$request->name){
        $user->name=$request->name;
        $user->save();
    }
    if ($mobile1->number!=$request->mobile){
        $mobile1->delete();
        $user->mobiles()->detach();
        $mobile=new \App\Mobile();
        $mobile->number=$request->mobile;
        $mobile->save();
        $user->mobiles()->attach($mobile);
    }

    return redirect('/profile');

});


Route::post('/updatepass', function (Request $request) {

    $user=auth()->user();
    if (password_verify($request->oldpass, $user->password)){
        if ($request->newpass==$request->confnewpass){
            $user->password=Hash::make($request->newpass);
            $user->save();
        }
    }

    return redirect('/profile');

});



Route::post('/city_add', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255'
    ]);

    //if ($validator->fails()) {
    //    return redirect( '/')
    //        ->withInput()
    //        ->withErrors($validator);
    //}

    $note = new \App\City;
    $note->name = $request->name;
    $note->count_shops = $request->count_shops;
    $note->money = $request->money;
    $note->save();


    return redirect('/home');

});

Route::get('/rout_add', function (Request $request) {
    $cities = \App\City::orderBy('name', 'asc')->get();
    $user = \App\User::where('email', 'driver@ex2life.com')->first();
    $shag=0;
    foreach ($cities as $city){
        $rout=new \App\Rout;
        $rout->shag_id=$shag;
        $rout->ident='1';
        $shag++;
        $rout->save();
        $rout->users()->attach($user);
        $rout->cities()->attach($city);
    };

    return 'ок';

});

Route::patch('/role_upd/{user}', function (\App\User $user, Request $request) {
    $role_new = \App\Role::where('id', $request->roleselect)->first();
    // Отсоединить все роли от пользователя...
    $user->roles()->detach();
    $user->roles()->attach($role_new);
    return redirect('/home/users');
});

Route::patch('/upd_rout/{user}', function (\App\User $user, Request $request) {;
    $user->routs()->detach();
    $shag=0;
    foreach ($request->selectcity as $selectedOption){
        $rout=new \App\Rout;
        $rout->shag_id=$shag;
        $rout->ident='0';
        $shag++;
        $rout->save();
        $rout->users()->attach($user);
        $city = \App\City::where('id', $selectedOption)->first();
        $rout->cities()->attach($city);
    }
    return redirect('/user_rout_select/'.$user->id);
});

//страница с формой Laravel регистрации пользователей
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');


Route::get('/uploadfile', function () {
    return view('uploadfile');
});

Route::get('/profile', function () {
    $user=auth()->user();
    $avatar=$user->avatars()->first()->path;
    $mobile=$user->mobiles()->first()->number;
    return view('profile', [
        'user' =>$user,
        'avatar' => $avatar,
        'mobile' => $mobile
    ]);
})->middleware('auth');

Route::get('/problems', function () {

    return view('problems');
})->middleware('auth');

Route::post('/problems', function (Request $request) {
    $problem=new \App\Problem();
    $problem->description=$request->problem;
    $problem->save();
    auth()->user()->problems()->attach($problem);

    return redirect('/home');
})->middleware('auth');

Route::post('/uploadfile','UploadFileController@fileUpload');

//далее для андроида


Route::get('/android-login', function () {
    return view('android-login');
});


Route::post('/unprotected/auth_android', function (Request $request) {
    $user = \App\User::where('email', $request->email)->first();
    if (password_verify($request->pass, $user['password'])){
        $user_send['name']=$user['name'];
        $user_send['token']=$user->gener_token();
        return json_encode($user_send);
    }
    else {
        return 'false';
    }

});


Route::post('unprotected/checktoken', function (Request $request) {
    $user = \App\User::where('email', $request->email)->first();
    if ($user->check_token($request->token)){
        return 'ok';
    }
    else{
        return 'nea';
    }
});

Route::match(array('GET', 'POST'),'unprotected/get_cities', function (Request $request) {
    $cities = \App\City::orderBy('name', 'asc')->get();
    return json_encode($cities);
});

Route::match(array('GET', 'POST'),'unprotected/get_users', function (Request $request) {
    $cities = \App\User::orderBy('name', 'asc')->get(['name', 'email', 'id']);

    return json_encode($cities);
});

Route::match(array('GET', 'POST'),'unprotected/user_info', function (Request $request) {
    $user_info = \App\User::where('id', $request->userid)->get(['id', 'name', 'email']);
    $user = \App\User::where('id', $request->userid)->first();
    $user_role=$user->roles()->get(['name', 'description']);
    $user_mobile=$user->mobiles()->get(['number']);
    $to_json= new \stdClass();
    $to_json->user_info=$user_info;
    $to_json->user_role=$user_role;
    $to_json->user_mobile=$user_mobile;
    return json_encode($to_json);
});

Route::match(array('GET', 'POST'),'unprotected/user_rout', function (Request $request) {
    $user = \App\User::where('email', $request->email)->first();
    $routs=$user->routs;
    foreach ($routs as $rout){
        $rout->city=$rout->cities[0]->name;
    }
    return json_encode($routs);
});