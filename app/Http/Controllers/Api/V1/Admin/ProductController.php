<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DTOs\Admin\ProductDestroyDTO;
use App\DTOs\Admin\ProductDTO;
use App\DTOs\Admin\ProductUpdateDTO;
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
        $query = Product::oldest()
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
        $dto = ProductDTO::fromRequest($request)->validatedData;

        $image = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('product');
        }

        Product::create([
            'title' => $dto['title'],
            'price' => $dto['price'],
            'image' => $image,
            'description' => $dto['description'],
            'available' => $dto['available'],
        ]);

        return responseJsonSuccess();
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
        // validation
        requestAddParam('product');
        $dto = ProductUpdateDTO::fromRequest($request)->validatedData;
        $update = Product::findOrFail($dto['id']);

        // check has image
        $image = $update->image;
        if ($request->hasFile('image')) {
            $this->deleteImage($image);
            $image = $request->file('image')->store('product');
        }

        // update
        $update->update([
            'title' => $dto['title'],
            'price' => $dto['price'],
            'image' => $image,
            'description' => $dto['description'],
            'available' => $dto['available'],
        ]);

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
        requestAddParam('product');
        $dto = ProductDestroyDTO::fromRequest($request)->validatedData;
        $destroy = Product::findOrFail($dto['id']);
        $this->deleteImage($destroy->image);
        $destroy->shoppingCarts()->delete();
        $destroy->delete();
        return responseJsonSuccess();
    }

    private function deleteImage($image) {
        Storage::delete($image);
    }

}
