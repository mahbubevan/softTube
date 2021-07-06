<?php

namespace App\Http\Controllers\Admin\Video;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list()
    {
        $pageTitle = "Category Lists";
        $pageSubTitle = "Videos";
        $categories = Category::orderBy('id', 'desc')->paginate(10);

        return \view('admin.video.category.list', \compact('categories', 'pageTitle', 'pageSubTitle'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:32|unique:categories,name'
        ]);

        $cat = new Category();
        $cat->name =  $request->name;
        $cat->save();

        return \back()->with('success', 'Category Created Successfully');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:32|unique:categories,name,except,id',
            'catId' => 'required|integer'
        ]);

        $cat = Category::where('id', $request->catId)->first();
        if (!$cat) return \back()->with('error', 'Invalid Category');

        $cat->previous_name =  $cat->name;
        $cat->name =  $request->name;
        $cat->update();

        return \back()->with('success', 'Category Updated Successfully');
    }
}
