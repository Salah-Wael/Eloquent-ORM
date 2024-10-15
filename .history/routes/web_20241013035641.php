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

########################################### create/insert/firstOrCreate/firstOrNew/insertGetId ##########################################################
Route::get('/create', function () {
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

########################################### update/updateOrCreate/updateOrInsert ##########################################################
Route::get('/update', function () {

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

########################################### isClean/isDirty/wasChanged/getOriginal ##########################################################
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

########################################### Upsert ##########################################################
Route::get('/upsert', function () {
    $users = [
        ['name' => 'snsn', 'email' => '11snsn@gmail.com', 'password' => '123456'],
        ['name' => 'smsm', 'email' => 'smsm@gmail.com', 'password' => '123456'],
        ['name' => 'nmnm', 'email' => '11nmnm@gmail.com', 'password' => '123456'],
        ['name' => 'fkha', 'email' => '11fkha@gmail.com', 'password' => '123456'],
    ];

    User::upsert($users, ['email' => 'smsm@gmail.com'], ['name' => 'Salah', 'email' => 'sasa.wael2016@yahoo.com', 'password' => '987654']);
});


########################################### Retrieval ##########################################################
########################################### find/findOr/findOrFail/first/firstOr/first/all/get/select/addSelect ##########################################################
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

    // $userEmail = User::where('role', 'admin')->first()->value('email');//return value
    // ==
    // $userEmail = User::where('role', 'admin')->first(['email']);//return collection
    // dump($userEmail);






    #################pluck (max pass 2)###################
    //
    /**                                 value    key
        $user = User::where('role', 'user')->pluck('name', 'email'); //get column (base collection)
        dump($user);
        $user = User::where('role', 'user')->pluck('password', 'email')->toArray(); //get column (array)
        dump($user);
     */

    /**
        // Initialize the $user array
        $user = User::where('role', 'user')->pluck('name', 'email')->toArray();

        // Merge the two collections into one array
        $passwords = User::where('role', 'user')->pluck('password', 'email')->toArray();

        // Merge the arrays with email as the key
        foreach ($passwords as $email => $password) {
            if (isset($user[$email])) {
                $user[$email] = [
                    'name' => $user[$email],
                    'password' => $password
                ];
            }
        }

        dump($user);
     */
});

########################################### Aggregate ##########################################################
Route::get('/aggregate', function () {
    // $user = User::count();
    // $user = User::sum('wallet');
    // $user = User::where('role', 'user')->sum(DB::raw('wallet + id'));
    // $user = User::avg('wallet');
    // $user = round(User::avg('wallet'), 2);
    // $walletData = [
    //     'min_wallet' => User::min('wallet'),
    //     'max_wallet' => User::max('wallet'),
    // ];
    // dump($walletData);
});

##################################### where & orWhere & whereBetween & whereNotBetween ############################################
Route::get('/where', function () {

    /**
        $users = User::where('id', '=', 5)->orWhere('wallet', '>', 500)
        ->select(['id', 'name as full_name', 'role', 'wallet as payment', 'created_at', 'updated_at'])
        ->get();
     */

    /**
        $users = User::where('wallet', '<', 500)->orWhere('wallet', '>', 500)
            ->select(['id', 'name as full_name', 'role', 'wallet as payment', 'created_at', 'updated_at'])
            ->get();
        dump($users);
        // ==
        $users = User::whereBetween('wallet', [275, 857])->get();
        dump($users);
        // !=
        $users = User::whereNotBetween('wallet', [275, 857])->get();
        dump($users);
     */

    /**
    // where = and where
        $users = User::where('wallet', '<', 500)->where('role', 'salesman')
            ->select(['id', 'name as full_name', 'role', 'wallet as payment', 'created_at', 'updated_at'])
            ->get();
        dump($users);
        // ==
        $users = User::where([
            ['wallet', '<', 500],
            ['role', 'salesman'],
        ])
            ->select(['id', 'name as full_name', 'role', 'wallet as payment', 'created_at', 'updated_at'])
            ->get();
        dump($users);
     */

    // $users = User::where('role', 'user')->where(function ($query) {
    //     $query->where('wallet', '>', 800);
    // })
    //     ->select(['id', 'name as full_name', 'role', 'wallet as payment', 'created_at', 'updated_at'])
    //     ->get();
    // dump($users);

    ###################################################### whereNull & whereNotNull #################################################################
    // $users = User::orWhere('name', Null)->get();
    // dump($users);
    // $users = User::orWhere('name', '')->get();
    // dump($users);
    // $users = User::whereNull('name')->get();
    // dump($users);
    // $users = User::whereNotNull('name')->select('name')->get();
    // dump($users);

    ############################################################### firstWhere ###########################################################
    // $users = User::firstWhere('role', 'user');
    // $users = User::firstWhere([
    //     ['role', 'user'],
    //     ['wallet', '>', 800],
    // ]);
    // dump($users);

    ############################################################### whereColumn ###########################################################
    // $users = User::whereColumn('wallet', '>', 'wallet2')->get();

    // $users = User::whereName('Carlo Kris')->get();
    // $users = User::whereWallet2(500.00)->get();
    // $users = User::whereRememberToken("r6kuqwuVkA")->first();
    // $users = User::whereCreatedAt("2024-09-29 12:57:35")->get();

    // dump($users);

    ################################################## whereDate & whereDay & whereMonth & whereYear ###########################################################
    // $users = User::whereDate('created_at', '2024-09-29')->get();
    // $users = User::whereDate('created_at', '<', '2024-09-29')->get();

    // $users = User::whereDay('created_at', '29')->get();
    // $users = User::whereDay('created_at', '<=', '6')->get();

    // $users = User::whereMonth('created_at', '09')->get();
    // $users = User::whereMonth('created_at', '<>', '09')->get();

    // $users = User::whereYear('created_at', '2024')->get();
    // $users = User::whereYear('created_at', '!=', '2024')->get();

    // dump($users);


    ############################################### whereAny & whereAll #########################################################
    // $users = User::whereAny(['wallet', 'wallet2'], '=', '500')->get(); // work as || or
    // $users = User::whereAll(['wallet', 'wallet2'], '=', 500)->get(); // work as && and
    // $users = User::whereAll(['wallet', 'wallet2'], '=', '500')->get(); // work as && and

    // $users = User::whereAny(['name', 'email'], 'LIKE', '%test%')->get(); // work as || or
    // $users = User::whereAll(['name', 'email'], 'LIKE', '%test%')->get(); // work as && and

    // dump($users);

    ############################################ whereIn & whereNotIn & whereInStrict(work with collection) ######################################
    /**
        $users = User::whereIn('role', ['admin', 'salesman'])->select('role')->get();
        dump($users);
        // ==
        $users = User::whereNotIn('role', ['user'])->select('role')->get();
        dump($users);
     */

    /**
        $users = User::whereIn('id', ["1", 2, "3"])->select('role')->get();
        dump($users);

        // ==
        $users = User::whereNotIn('id', [4, 5, 6])->select('role')->get();
        dump($users);
        // ==
        $users = User::find([1, 2, 3])->select('role');
        dump($users);
     */

    // $users = User::get();
    // dump($users->whereInStrict('id', [1, '2', 3])->select(['id', 'role'])); // check '2'
    // not return user who id = '2' because whereInStrict check the data type of the column and what do you pass

    #################################### whereStrict (work with collection only) #########################################
    // $users = User::where('role', 'user')
    //     ->select(['id', 'name as full_name', 'role', 'wallet as payment'])
    //     ->addSelect(['created_at', 'updated_at'])
    //     ->get();
    // dump($users);
    // dump($users->whereStrict('payment', 857)); // true
    // dump($users->whereStrict('payment', '857'));
    // dump($users->whereStrict('wallet', 857));
    // dump($users->whereStrict('wallet', '857'));
});

########################################### When/whenEmpty/whenNotEmpty ##########################################################
Route::get('/when', function () {
    // $user = User::when(condition, true, false);

    // $user = User::when(false, function ($query) {
    //     return $query->where('role', 'admin');
    // }, function ($query) {
    //     return $query->whereIn('role', ['user', 'salesman'])->orderBy('role');
    // });


    // $user->whenEmpty(collection is empty, collection has data)
    $user = User::whereNull('email')->get();
    dump($user);

    $user->whenEmpty(function () {
        dump('empty');
    }, function () {
        dump('not empty');
    });

    $user->whenNotEmpty(function () {
        dump('not empty');
    }, function () {
        dump('empty');
    });
});

########################################### delete/destroy/truncate ##########################################################

Route::get('delete', function () {
    // $user = User::find(1)->delete(); // boolean->ture
    //// ==
    // $user = User::destroy(6);// Return the number of deleted records->integer->1

    $user = User::find([2, 3, 8]);// Return the number of deleted records->integer->3

    // $user = User::whereIn('id', [2, 3, 8])->delete(); // Return the number of deleted records->integer->3
    // $user = User::destroy([2, 3, 8]);// boolean->ture
    dd($user);
});
