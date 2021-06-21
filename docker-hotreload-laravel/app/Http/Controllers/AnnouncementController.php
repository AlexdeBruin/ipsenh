<?php

namespace App\Http\Controllers;

use App\Announcement;

class AnnouncementController extends Controller
{
    public function all(){
        return Announcement::all();
    }
    public function show($id)
    {
        return Announcement::findOrFail($id);
    }
}
