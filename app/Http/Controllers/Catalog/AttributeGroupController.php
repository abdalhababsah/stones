<?php
namespace App\Http\Controllers\Catalog;

use App\DataTables\Catalog\AttributeGroupsDataTable; 
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeGroup\StoreRequest; 
use App\Http\Requests\AttributeGroup\UpdateRequest; 
use App\Models\AttributeGroup;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    public function index(AttributeGroupsDataTable $dataTable)
    {
        return $dataTable->render('pages.catalog.attributes.attributeGroups.list');
    }

    public function create()
    {
        $categories = Category::all(); 
        return view('pages.catalog.attributes.attributeGroups.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $request->validated(); 
            $attributeGroup = AttributeGroup::create($request->only(['name_en', 'sort_order']));
            if ($request->has('category_ids')) {
                $attributeGroup->categories()->sync($request->category_ids);
            }
    
            return response()->json(['message' => 'Attribute Group Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error('Error in storing attribute group: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to add attribute group', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
    

    public function edit(AttributeGroup $attributeGroup)
    {
        $categories = Category::all(); 
        return view('pages.catalog.attributes.attributeGroups.create', compact('attributeGroup', 'categories'));
    }

    public function update(UpdateRequest $request, AttributeGroup $attributeGroup)
    {
        try {
            $request->validated(); 
            $attributeGroup->update($request->only(['name_en', 'sort_order']));
            
            if ($request->has('category_ids')) {
                $attributeGroup->categories()->sync($request->category_ids);
            }
    
            return response()->json(['message' => 'Attribute Group Updated Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error('Error in updating attribute group: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update attribute group', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
    
    public function destroy($id)
    {
        try {
            AttributeGroup::where('id', $id)->delete();
            return response()->json(['message' => 'Attribute Group Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => 'Failed to delete attribute group', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
