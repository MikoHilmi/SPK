<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserRepository
{

    protected $user;

    public function __construct(User $con)
    {
        $this->user = $con;
    }

    public function user()
    {
        return DB::table('users')
            ->join('user_groups', 'users.id', '=', 'user_groups.user_id')
            ->join('groups', 'user_groups.group_id', '=', 'groups.id')
            ->select('users.id', 'users.name', 'users.email', 'users.status', 'groups.name as role')
            ->get();
    }

    public function detail_user($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }
}
