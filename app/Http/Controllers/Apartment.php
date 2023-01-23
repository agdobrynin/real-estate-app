<?php

namespace App\Http\Controllers;

use App\Models\Apartment as ApartmentModel;
use Illuminate\Http\Request;

class Apartment extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ApartmentModel::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response|\Inertia\ResponseFactory
    {
        $filters = $request->only(['priceMin', 'priceMax', 'beds', 'baths', 'areaMin', 'areaMax']);
        $query = ApartmentModel::SortByCreated()
            ->filters($filters)
            ->paginate(8)
            ->withQueryString();

        return inertia('Apartment/Index', [
            'filters' => $filters,
            'list' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Apartment/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->user()->apartments()->create(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:12|max:1000',
                'city' => 'required|string|min:5',
                'street' => 'required|string|min:5',
                'code' => 'required|string|min:1',
                'street_nr' => 'required|integer|min:1',
                'price' => 'required|integer|min:1',
            ])
        );

        return redirect()
            ->route('apartment.index')
            ->with('success', 'Apartment was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApartmentModel $apartment): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Apartment/Show', [
            'apartment' => $apartment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApartmentModel $apartment): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Apartment/Edit', [
            'apartment' => $apartment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApartmentModel $apartment): \Illuminate\Http\RedirectResponse
    {
        $apartment->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:12|max:1000',
                'city' => 'required|string|min:5',
                'street' => 'required|string|min:5',
                'code' => 'required|string|min:1',
                'street_nr' => 'required|integer|min:1',
                'price' => 'required|integer|min:1',
            ])
        );

        return redirect()
            ->route('apartment.show', [$apartment])
            ->with('success', 'Apartment was updated');
    }
}
