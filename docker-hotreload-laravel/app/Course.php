<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 09-May-19
 * Time: 11:58
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $timestamps = false;

    protected $fillable = ['course_code', 'course_description', 'semester', 'year', 'ec'];

    protected $casts = [
        'semester'  => 'array',
        'ec'        => 'integer'
    ];

    public function specialisations(){
        return $this->belongsTo(Specialisation::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('role', 'showing');
    }

    public function tests(){
        return $this->hasMany(Test::class);
    }

    public function uploadedFiles(){
        return $this->hasMany(Uploaded_File::class);
    }

    public function announcements(){
        return $this->hasMany(Announcement::class);
    }
}