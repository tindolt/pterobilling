<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function show()
    {
        return view('admin.announce', ['title' => 'Announcements', 'announcement' => Announcement::orderBy('id', 'asc')->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'theme' => 'required|integer|in:0,1,2,3',
        ]);

        $announcement = Announcement::find(1);
        $announcement->value = $request->input('enable') ? true : false;
        $announcement->save();

        $this->saveAnnouncement($request, 2, 'subject');
        $this->saveAnnouncement($request, 3, 'content');
        $this->saveAnnouncement($request, 4, 'theme');

        return back()->with('success_msg', 'You have updated the announcement! Please click \'Reload Config\' above on the navigation bar to publish the changes.');
    }

    private function saveAnnouncement(Request $request, $id, $key)
    {
        $announcement = Announcement::find($id);
        $announcement->value = $request->input($key);
        $announcement->save();
    }
}
