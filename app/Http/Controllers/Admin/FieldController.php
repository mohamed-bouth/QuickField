<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    public function index()
    {
        return view('admin.fields.index');
    }

    public function create()
    {
        return view('admin.fields.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:5v5,7v7',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $imagePath = Storage::disk('r2')->putFile('fields', $request->file('image'), 'public');
        $imageUrl = Storage::disk('r2')->url($imagePath);

        Field::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'localisation' => $validated['localisation'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('admin.fields.index')
            ->with('success', 'Field created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $field = Field::findOrFail($id);

        return view('admin.fields.edit', compact('field'));
    }

    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:5v5,7v7',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $imagePath = $field->image_path;
        $imageUrl = $field->image_url;

        if ($request->hasFile('image')) {
            if ($field->image_path) {
                Storage::disk('r2')->delete($field->image_path);
            }

            $imagePath = Storage::disk('r2')->putFile('fields', $request->file('image'), 'public');
            $imageUrl = Storage::disk('r2')->url($imagePath);
        }

        $field->update([
            'name' => $validated['name'],
            'localisation' => $validated['localisation'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('admin.fields.index')
            ->with('success', 'Field updated successfully.');
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        if ($field->image_path) {
            Storage::disk('r2')->delete($field->image_path);
        }

        $field->delete();

        return redirect()
            ->route('admin.fields.index')
            ->with('success', 'Field deleted successfully.');
    }
}