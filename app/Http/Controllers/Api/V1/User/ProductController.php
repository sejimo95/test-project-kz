<?php

namespace App\Http\Controllers\Api\V1\User;

use App\DTOs\User\ProductDTO;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $dto = ProductDTO::fromRequest($request)->validatedData;

        // sortBy id OR price
        $query = Product::orderBy($dto->sortBy, $dto->descending);

        // search in [title, price, description]
        $search = $dto->search;
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('price', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        // filter by available
        $available = $dto->available;
        if ($available) {
            $query->where('available', $available);
        }

        return responseJson(['date' => $query->paginate(10)],200);
    }

}
