<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 24-Apr-19
 * Time: 12:01
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Student_Info extends Model
{
    protected $primaryKey = 'student_number';

    protected $table = 'student_info';

    protected $with = [
        'specialisation'
    ];

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_number'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function specialisation(){
        return $this->belongsTo(Specialisation::class);
    }
}