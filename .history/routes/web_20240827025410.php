<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/collection', function () {

    $numbers = collect([1, 2, 3]);
    $greaterThanTwo = $numbers->filter(fn ($numbers) => $numbers > 2);

    dump($numbers);
    dump($greaterThanTwo);
});

Route::get('/create/insert/firstOrCreate/firstOrNew/insertGetId', function () {
    $user = new User();
    $user->name = 'salah';
    $user->gender = 'male';
    $user->password = 'smsm';
    $user->save(); //for insert & update

    $user = User::create([
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]);

    $user = User::insert([
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]); //return boolean value


    $user = User::firstOrCreate(['key' => 'value to check'], [
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]); //create in DB

    $user = User::firstOrNew([], [
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]); //make without push in DB
    $user->save(); //if you want to save it

    $user = User::insertGetId([
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]); //return value of id of inserted row

});

Route::get('/update/updateOrCreate/updateOrInsert', function () {

    $user = User::find(1)->update([
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]);

    $user = User::updateOrCreate(['email' => 'sasa.wael2016@gmail.com'], [
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]);

    // using updateOrInsert() with query builder is the best
    $user = DB::table('users')->updateOrInsert(['check' => 'this value if existed'], [
        'name' => 'salah',
        'gender' => 'male',
        'password' => 'smsm',
    ]); //return boolean value with query builder

});

Route::get('/isClean/isDirty/wasChanged/getOriginal', function () {

    $user = User::find(1);
    $user->isClean(); //check on all the instance
    $user->isClean(['email', 'password']); //check only on email, password is clean?
    // ********************************************************

    $user->isDirty();
    // ********************************************************

    $user->wasChanged(); //check after save in database
    // ********************************************************

    $user->getOriginal();
});

Route::get('/upsert', function () {
    $users = [
        ['name' => 'snsn', 'email' => '11snsn@gmail.com', 'password' => '123456'],
        ['name' => 'smsm', 'email' => 'smsm@gmail.com', 'password' => '123456'],
        ['name' => 'nmnm', 'email' => '11nmnm@gmail.com', 'password' => '123456'],
        ['name' => 'fkha', 'email' => '11fkha@gmail.com', 'password' => '123456'],
    ];

    User::upsert($users, ['email' => 'smsm@gmail.com'], ['name' => 'Salah', 'email' => 'sasa.wael2016@yahoo.com', 'password' => '987654']);
});


###########################################Retrieval##########################################################
Route::get('/retrieve', function () {

    ##############all###################
    // $users = User::all();
    // $users = User::all(['email', 'password']);
    // $users = User::all(['email as smsm', 'password']);//alias email => smsm

    ##############get###################
    // $users = User::get();// == User::all()
    // $users = User::where('name', 'fkha')->get();
    // $users = User::get(['email', 'password']);
    // $users = User::where('name', 'fkha')->get(['email as smsm', 'password']);//alias email => smsm

    ##############select###################
    // $users = User::select('email', 'password')->get();
    // $users = User::where('name', 'fkha')->select(['name as smsm', 'password'])->get();

    ##############addSelect###################
    // $users = User::select('email', 'password')->get();

    // $users = User::where('name', 'fkha')
    //             ->select(['name as smsm', 'password'])
    //             ->addSelect('role')
    //             ->get();

    // $users = User::where('name', 'fkha')
    //             ->select(['name', 'password']);
    // $users= $users->addSelect('role')->get();

    #################find###################
    // $user = User::find(1);
    // $user = User::find(1, ['name as username', 'role', 'created_at', 'updated_at']);
    // $user = User::find([1, 2, 3], ['name as username', 'role', 'created_at', 'updated_at']);

    #################findOr###################
    // $user = User::findOr(500, function () {
    //     return dd('ss');
    // });

    #################findOrFail###################
    // $user = User::findOrFail(500);

    #################first###################
    // $user = User::where('role', 'admin')->first();
    // $user = User::where('id', '6')->first(['id','name as username', 'role', 'created_at', 'updated_at']);

    #################firstOr###################
    // $user = User::where('id',600)->firstOr(function () {
    //     return dd('ss');
    // });

    #################firstOrFail###################
    // $user = User::where('id', 600)->firstOrFail();
    // dump($user);

    #################value###################
    /*
    $userEmail = User::where('role', 'admin')->first(['email'])->value('email');
    ==
    $userEmail = User::where('role', 'admin')->first(['email']);
    dump($userEmail);
     */

    #################pluck###################
    //                                         value    key
    $user = User::where('role', 'user')->pluck('name' ,'email');//get column (base collection)
    $user = User::where('role', 'user')->pluck('name' ,'email')->toArray();//get column (array collection)
    dump($user);
});

###########################################Aggregate##########################################################
Route::get('/aggregate', function () {

});
