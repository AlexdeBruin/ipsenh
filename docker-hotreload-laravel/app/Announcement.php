<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 14-May-19
 * Time: 12:47
 */

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['announcement'];

    protected $dates = ['created_at'];

    protected $appends = ['formatted_created_at'];

    public function getFormattedCreatedAtAttribute(){
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
}