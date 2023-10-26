<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{


    function __construct()
    {
        // users need to have at least one or more of the following permissions to be able to access the foplloowing functions
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }



    public function index(): View
    {
        $products = Products::latest()->paginate(5);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create(): View
    {
        return view('products.create');
    }


    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Products::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }


    public function show(Products $product): View
    {
        return view('products.show', compact('product'));
    }


    public function edit(Products $product): View
    {
        return view('products.edit', compact('product'));
    }


    public function update(Request $request, Products $product): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }


    public function destroy(Products $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
