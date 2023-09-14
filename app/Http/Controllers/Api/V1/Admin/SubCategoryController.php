<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DTOs\Admin\SubCategoryDestroyDTO;
use App\DTOs\Admin\SubCategoryDTO;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dto = SubCategoryDTO::fromRequest($request)->validatedData;
        SubCategory::create($dto);
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
        requestAddParam('sub_category');
        $dto = SubCategoryDestroyDTO::fromRequest($request)->validatedData;
        SubCategory::findOrFail($dto['id'])->delete();
        return responseJsonSuccess();
    }
}
