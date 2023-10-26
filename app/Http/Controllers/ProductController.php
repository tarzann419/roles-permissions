<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
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
