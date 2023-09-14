<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DTOs\Admin\CategoryDestroyDTO;
use App\DTOs\Admin\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Category::latest()
            ->with('subCategories')
            ->paginate(10);

        return responseJson(['date' => $query],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dto = CategoryDTO::fromRequest($request)->validatedData;
        $category = Category::create($dto);

        $insertSubCategories = [];
        foreach ($dto['sub_category'] as $item) {
            array_push($insertSubCategories,['title' => $item, 'category_id' => $category->id]);
        }

        $category->subCategories()->insert($insertSubCategories);
        return responseJsonSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        requestAddParam('category');
        $dto = CategoryDestroyDTO::fromRequest($request)->validatedData;
        $destroy = Category::findOrFail($dto['id']);
        $destroy->subCategories()->delete();
        $destroy->delete();
        return responseJsonSuccess();
    }
}
