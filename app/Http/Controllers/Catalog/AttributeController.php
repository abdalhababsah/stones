<?php

namespace App\Http\Controllers\Catalog;

use App\DataTables\Catalog\AttributeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\StoreRequest;
use App\Http\Requests\Attribute\UpdateRequest;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use Illuminate\Support\Arr;

class AttributeController extends Controller
{
    public function index(AttributeDataTable $dataTable)
    {
        return $dataTable->render('pages.catalog.attributes.attribute.list');
    }

    public function create()
    {
        $attributeGroups = AttributeGroup::get(['id', 'name_en']);
        return view('pages.catalog.attributes.attribute.create', compact('attributeGroups'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $values = [];
            foreach (request('names') as $key => $item) {
                $values [] = [
                    'name_en' => $item,
                    'sort_order' => Arr::get(request('orders'), $key),
                    'attribute_group_id' => request('attribute_group_id'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Attribute::insert($values);

            return response()->json(['message' => 'Attribute Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error('Error in storing attribute: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to add attribute', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function edit(Attribute $attribute)
    {
        $attributeGroups = AttributeGroup::all();
        return view('pages.catalog.attributes.attribute.create', compact('attribute', 'attributeGroups'));
    }

    public function update(UpdateRequest $request, Attribute $attribute)
    {


        try {
            // $request->validate($request->rules());
            $attribute->update($request->all());

            return response()->json(['message' => 'Attribute Updated Successfully', 'status' => 200,'attribute'=>$attribute]);
        } catch (\Exception $e) {
            \Log::error('Error in updating attribute: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to update attribute', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function destroy($id)
    {
        try {
            Attribute::where('id', $id)->delete();
            return response()->json(['message' => 'Attribute Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => 'Failed to delete attribute', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
