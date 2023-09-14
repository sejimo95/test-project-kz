<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DTOs\Admin\ProductDTO;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::oldest();
        return responseJson(['date' => $query->paginate(10)],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dto = $this->validationDTO($request);
        Product::create($dto);
        return responseJson([],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $dto = $this->validationDTO($request);
        $update = Product::findOrFail($dto->id);
        $update->update($dto);
        return responseJson([],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Product::findOrFail($id);
        Storage::delete($destroy->image);
        $destroy->delete();
        return responseJson([],200);
    }

    private function validationDTO ($request) {
        return ProductDTO::fromRequest($request)->validatedData;
    }
}
