<?php

namespace App\Http\Controllers;

use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class ProductPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);
        
        $files = [];
        if ($request->file('files')){
            foreach($request->file('files') as $key => $file)
            {
                $file_name = time().rand(1,99).'.'.$file->extension();  
                $file->move(public_path('uploads'), $file_name);
                $files[]['name'] = $file_name;
            }
        }
    
        foreach ($files as $key => $file) {
            ProductPhoto::create($file);
        }
       
        return back()->with('success','File uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductPhoto $productPhoto)
    {
        //
    }
}
