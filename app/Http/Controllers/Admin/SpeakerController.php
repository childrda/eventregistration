<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSpeakerRequest;
use App\Http\Requests\Admin\UpdateSpeakerRequest;
use App\Models\Speaker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::query()
            ->forAdminEvent()
            ->orderBy('sort_order')
            ->paginate(15);

        return view('admin.speakers.index', compact('speakers'));
    }

    public function create()
    {
        return view('admin.speakers.create');
    }

    public function store(StoreSpeakerRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $this->storeSpeakerImage($request->file('image_path'));
        }
        $data['event_id'] = session('admin_event_id');
        Speaker::query()->create($data);

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker created.');
    }

    public function show(Speaker $speaker)
    {
        return view('admin.speakers.show', compact('speaker'));
    }

    public function edit(Speaker $speaker)
    {
        return view('admin.speakers.edit', compact('speaker'));
    }

    public function update(UpdateSpeakerRequest $request, Speaker $speaker)
    {
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $this->deleteSpeakerImage($speaker->image_path);
            $data['image_path'] = $this->storeSpeakerImage($request->file('image_path'));
        } else {
            unset($data['image_path']);
        }
        $speaker->update($data);

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker updated.');
    }

    public function destroy(Speaker $speaker)
    {
        $this->deleteSpeakerImage($speaker->image_path);
        $speaker->delete();

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker deleted.');
    }

    protected function storeSpeakerImage($file): string
    {
        $dir = public_path('uploads/speakers');
        File::ensureDirectoryExists($dir);

        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'uploads/speakers/'.$filename;
    }

    protected function deleteSpeakerImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (str_starts_with($path, 'uploads/')) {
            File::delete(public_path($path));

            return;
        }

        Storage::disk('public')->delete($path);
    }
}
