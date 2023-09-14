<?php

namespace App\Http\Controllers\Api\V1\User;

use App\DTOs\User\ShoppingCartDestroyDTO;
use App\DTOs\User\ShoppingCartDTO;
use App\Http\Controllers\Controller;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = ShoppingCart::latest()
            ->where('user_id', auth()->user()->id)
            ->with('product')
            ->get();

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
        $dto = ShoppingCartDTO::fromRequest($request)->validatedData;
        ShoppingCart::create($dto);
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
        requestAddParam('shopping_cart');
        $dto = ShoppingCartDestroyDTO::fromRequest($request)->validatedData;
        ShoppingCart::findOrFail($dto['id'])->delete();
        return responseJsonSuccess();
    }
}
