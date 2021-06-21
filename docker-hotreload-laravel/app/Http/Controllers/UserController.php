<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 27-Mar-19
 * Time: 11:59
 */

namespace App\Http\Controllers;


use App\User;

class UserController extends Controller
{
    public function show($id)
    {
        return User::query()->findOrFail($id);
    }

    public function all()
    {
        Return User::all();
    }

}