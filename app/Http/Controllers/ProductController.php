<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            dd('a');
            $products = Product::latest()->get();

            if (is_null($products->first())) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No product found!',
                ], 200);
            }

            $response = [
                'status' => 'success',
                'message' => 'Products are retrieved successfully.',
                'data' => $products,
            ];

            return response()->json($response, 200);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            dd('b');
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:250',
                'description' => 'required|string|'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);
            }

            $product = Product::create($request->all());

            $response = [
                'status' => 'success',
                'message' => 'Product is added successfully.',
                'data' => $product,
            ];

            return response()->json($response, 200);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            dd('c');
            $product = Product::find($id);

            if (is_null($product)) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product is not found!',
                ], 200);
            }

            $response = [
                'status' => 'success',
                'message' => 'Product is retrieved successfully.',
                'data' => $product,
            ];

            return response()->json($response, 200);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            dd('d');
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);
            }

            $product = Product::find($id);

            if (is_null($product)) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product is not found!',
                ], 200);
            }

            $product->update($request->all());

            $response = [
                'status' => 'success',
                'message' => 'Product is updated successfully.',
                'data' => $product,
            ];

            return response()->json($response, 200);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            dd('e');
            $product = Product::find($id);

            if (is_null($product)) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product is not found!',
                ], 200);
            }

            Product::destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Product is deleted successfully.'
            ], 200);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    /**
     * Search by a product name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        try {
            dd('f');
            $products = Product::where('name', 'like', '%' . $name . '%')
                ->latest()->get();

            if (is_null($products->first())) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No product found!',
                ], 200);
            }

            $response = [
                'status' => 'success',
                'message' => 'Products are retrieved successfully.',
                'data' => $products,
            ];

            return response()->json($response, 200);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
}