<?php

namespace App\Http\Controllers\Home;

use App\DataTables\Home\HomeImagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeImagesController extends Controller
{
    public function index(HomeImagesDataTable $dataTable)
    {
        return $dataTable->render('pages.home.images.list');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('pages.home.images.create');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'image_title'=>'required|string',
            'image_path' => 'required|image',
            'sort_order' => 'required|integer',
        ]);

        try {
            if ($request->hasFile('image_path')) {
                $filename = Str::slug($request->input('name'), '_');
                $extension = $request->file('image_path')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $validatedData['image_path'] = Storage::disk('s3')->putFileAs('home_images', $request->file('image_path'), $fileNameToStore);
            }

            Home::create($validatedData);

            return response()->json(['message' => 'Home Image Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add home image', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function edit(Home $home): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('pages.home.images.create', compact('home'));
    }

    public function update(Request $request, Home $home): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'image_path' => 'image|nullable',
            'sort_order' => 'required|integer',
        ]);

        try {
            if ($request->hasFile('image_path')) {
                $filename = Str::slug($request->input('name'), '_');
                $extension = $request->file('image_path')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $validatedData['image_path'] = Storage::disk('s3')->putFileAs('home_images', $request->file('image_path'), $fileNameToStore);

                // Optionally delete the old image from S3
                if ($home->image_path) {
                    Storage::disk('s3')->delete($home->image_path);
                }
            }

            $home->update($validatedData);

            return response()->json(['message' => 'Home Image Updated Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update home image', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function destroy(Home $home): \Illuminate\Http\JsonResponse
    {
        try {
            if ($home->image_path) {
                Storage::disk('s3')->delete($home->image_path);
            }

            $home->delete();

            return response()->json(['message' => 'Home Image Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete home image', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
