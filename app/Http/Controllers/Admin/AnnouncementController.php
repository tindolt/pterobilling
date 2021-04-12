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

        $announcement = Announcement::where('key', 'enabled')->first();
        $announcement->value = $request->has('enabled');
        $announcement->save();

        $this->saveAnnouncement($request, 'subject');
        $this->saveAnnouncement($request, 'content');
        $this->saveAnnouncement($request, 'theme');

        return back()->with('success_msg', 'You have updated the announcement! Please click \'Reload Config\' above on the navigation bar to publish the changes.');
    }

    private function saveAnnouncement(Request $request, $key)
    {
        $announcement = Announcement::where('key', $key)->first();
        $announcement->value = $request->input($key);
        $announcement->save();
    }
}
