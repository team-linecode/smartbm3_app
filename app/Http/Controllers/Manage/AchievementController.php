<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        $this->authorize('read achievement');

        $achievements = Achievement::all();
        return view('manage.achievement.index', [
            'achievements' => $achievements
        ]);
    }

    public function create()
    {
        $this->authorize('create achievement');

        return view('manage.achievement.create', [
            'teachers' => User::role('teacher')->where('is_hometeacher', "1")->get(),
            'students' => User::role('student')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create achievement');

        $rules = [
            'student' => 'required',
            'name' => 'required',
            'champion' => 'required',
            'level' => 'required',
            'date' => 'required|date',
            'attachment.*' => 'mimes:png,jpg,jpeg,pdf|max:102400',
        ];

        if ($request->teacher) {
            $rules['teacher'] = 'required';
        } else {
            $request['teacher'] = auth()->user()->id;
        }

        $request->validate($rules);

        User::findOrFail($request->teacher); // check user exists
        User::findOrFail($request->student); // check user exists

        $request['champion'] = ucwords($request['champion']);
        $request['level'] = ucwords($request['level']);
        $request['teacher_id'] = $request->teacher;
        $request['student_id'] = $request->student;
        
        $achievement = Achievement::create($request->all());

        if ($request->file('attachment')) {
            foreach ($request->file('attachment') as $file) {
                AchievementAttachment::create([
                    'achievement_id' => $achievement->id,
                    'file' => $file->store('achievement', 'public'),
                    'format' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize()
                ]);
            }
        }

        return redirect()->route('app.achievement.index')->with('success', 'Prestasi berhasil ditambahkan');
    }

    public function edit(Achievement $achievement)
    {
        $this->authorize('update achievement');

        return view('manage.achievement.edit', [
            'achievement' => $achievement,
            'teachers' => User::role('teacher')->where('is_hometeacher', "1")->get(),
            'students' => User::role('student')->get()
        ]);
    }

    public function update(Achievement $achievement, Request $request)
    {
        $this->authorize('update achievement');

        $rules = [
            'student' => 'required',
            'name' => 'required',
            'champion' => 'required',
            'level' => 'required',
            'date' => 'required|date',
            'attachment.*' => 'mimes:png,jpg,jpeg,pdf|max:102400',
        ];

        if ($request->teacher) {
            $rules['teacher'] = 'required';
        } else {
            $request['teacher'] = auth()->user()->id;
        }

        $request->validate($rules);

        User::findOrFail($request->teacher); // check user exists
        User::findOrFail($request->student); // check user exists

        $request['champion'] = ucwords($request['champion']);
        $request['level'] = ucwords($request['level']);
        $request['teacher_id'] = $request->teacher;
        $request['student_id'] = $request->student;
        
        $achievement->update($request->all());

        if ($request->file('attachment')) {
            foreach ($request->file('attachment') as $file) {
                AchievementAttachment::create([
                    'achievement_id' => $achievement->id,
                    'file' => $file->store('achievement', 'public'),
                    'format' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize()
                ]);
            }
        }

        return back()->with('success', 'Prestasi berhasil diupdate');
    }

    public function destroy(Achievement $achievement)
    {
        $this->authorize('delete achievement');

        foreach ($achievement->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file);
        }

        $achievement->attachments()->delete();
        $achievement->delete();

        return redirect()->route('app.achievement.index')->with('success', 'Prestasi berhasil dihapus');
    }
    
    public function attachment_destroy(AchievementAttachment $achievement_attachment)
    {
        $this->authorize('delete achievement attachment');

        Storage::disk('public')->delete($achievement_attachment->file);
        $achievement_attachment->delete();
        
        return back()->with('success', 'Lampiran berhasil dihapus');
    }
}
