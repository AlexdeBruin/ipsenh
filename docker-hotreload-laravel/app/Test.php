<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 09-May-19
 * Time: 13:56
 */

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['name', 'percentage', 'mandatory', 'semester', 'given_at', 'grades_inserted', 'retake'];

    protected $appends = ['formatted_given_at'];

    protected $casts = [
        'percentage' => 'integer',
        'mandatory' => 'boolean',
        'semester' => 'integer',
        'given_at' => 'datetime',
        'retake' => 'boolean'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('grade')->withTimestamps();
    }

    public function getFormattedGivenAtAttribute(){
        return Carbon::parse($this->given_at)->format('d-m-Y');
    }
}