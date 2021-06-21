<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 24-Apr-19
 * Time: 12:07
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Specialisation extends Model
{

    protected $fillable = [
        'name', 'description'
    ];


}