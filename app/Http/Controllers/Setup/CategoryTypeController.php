<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryType;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryTypeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role_or_permission:category.type.list|
                                               category.type.create|
                                               category.type.updation|
                                               category.type.delete|
                                               category.list.check'),
        ];
    }
    public function CategoryTypeIndex()
    {
        $categoryTypes =  CategoryType::all();

        return view('admin.setups.category_type.index', compact('categoryTypes'));
    }

    public function CategoryTypeAdd()
    {
        return view('admin.setups.category_type.add');
    }

    public function CategoryTypeStore(Request $request)
    {
        $validatedData = $request->validate([
            'category_type_name' => 'required|unique:category_types,name',
        ]);

        $data = new CategoryType();
        $data->name = $request->category_type_name;
        $data->slug = strtolower($request->category_type_name);
        $data->created_at = Carbon::now();
        $data->save();

        $notification = array(
            'message' => 'Category Type Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.type.index')->with($notification);
    }

    public function CategoryTypeEdit($id)
    {
        $editData = CategoryType::find($id);
        return view('admin.setups.category_type.edit', compact('editData'));
    }

    public function CategoryTypeUpdate(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('category_types')->ignore($id)],
        ]);

        $data = CategoryType::find($id);
        $data->name = $request->name;
        $data->slug = strtolower($request->name);
        $data->save();

        $notification = array(
            'message' => 'Category Type Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('category.type.index')->with($notification);
    }

    public function CategoryTypeDelete($id)
    {

        $catagory = CategoryType::find($id);
        $catagory->delete();

        $notification = array(
            'message' => 'Category Type Deleted Successfully',
            'alert-type' => 'error'
        );

        return redirect()->route('category.type.index')->with($notification);
    }

    public function CategoryList($id)
    {

        $categoryType = CategoryType::find($id);
        $categories = Category::where('category_type_id', $id)->get();

        return view('admin.setups.category_type.list', compact('categories', 'categoryType'));
    }
}
