<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 14-May-19
 * Time: 12:56
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Uploaded_File extends Model
{
    protected $table = 'uploaded_files';

    protected $fillable = ['file_path'];

    public function course(){
        $this->belongsTo(Course::class);
    }
}