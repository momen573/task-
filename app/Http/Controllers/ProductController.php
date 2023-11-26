<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function search(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        if ($request->has('min_price') || $request->has('max_price')) {

               $products=Product::with('variations')->whereHas('variations', function ($subQuery) use ($request) {
                   $minPrice = $request->input('min_price');
                   $maxPrice = $request->input('max_price');
                   $subQuery->whereBetween('price', [$minPrice, $maxPrice]);
               });
        }
        if ($request->has('name') and $products) {
            $name = $request->input('name');

            $products=$products->where('name', 'like', "%$name%");
        }
        $newRecords = [];

        foreach ($products->paginate(10) as $key=> $product) {
            $newRecords[$key]['name']=$product->name;
            foreach ($product->variations as $variation)
                if ($variation->price>=$request->input('min_price') && $variation->price<=$request->input('max_price'))
                $newRecords[$key]['variations'][]=$variation;
                }



        return response()->json(['data'=>$newRecords , 'page'=>$products->paginate(10) ]);
    }

}
