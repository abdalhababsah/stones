<?php

namespace App\Http\Controllers\Home;

use App\DataTables\Home\AboutUsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutUsController extends Controller
{
    public function index(AboutUsDataTable $dataTable)
    {
        // Render a DataTable view, assuming you have a blade file at the specified path
        return $dataTable->render('pages.home.about_us.list');
    }

    public function create()
    {
        // Return a view for creating a new About Us entry
        return view('pages.home.about_us.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image_path' => 'required|image',
            'content' => 'required|string',
        ]);

        try {
            if ($request->hasFile('image_path')) {
                $filename = Str::slug($request->input('name'), '_');
                $extension = $request->file('image_path')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $validatedData['image_path'] = Storage::disk('s3')->putFileAs('about_us_images', $request->file('image_path'), $fileNameToStore);
            }

            AboutUs::create($validatedData);

            return response()->json(['message' => 'About Us Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add About Us', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function edit(AboutUs $aboutUs)
    {
        // Return a view for editing an existing About Us entry
        return view('pages.home.about_us.create', compact('aboutUs'));
    }

    public function update(Request $request, AboutUs $aboutUs)
    {
        $validatedData = $request->validate([
            'image_path' => 'image|nullable',
            'content' => 'required|string',
        ]);

        try {
            if ($request->hasFile('image_path')) {
                $filename = Str::slug($request->input('name'), '_');
                $extension = $request->file('image_path')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $validatedData['image_path'] = Storage::disk('s3')->putFileAs('about_us_images', $request->file('image_path'), $fileNameToStore);

                // Optionally delete the old image from S3
                if ($aboutUs->image_path) {
                    Storage::disk('s3')->delete($aboutUs->image_path);
                }
            }

            $aboutUs->update($validatedData);

            return response()->json(['message' => 'About Us Updated Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update About Us', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function destroy(AboutUs $aboutUs)
    {
        try {
            if ($aboutUs->image_path) {
                Storage::disk('s3')->delete($aboutUs->image_path);
            }

            $aboutUs->delete();

            return response()->json(['message' => 'About Us Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete About Us', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
