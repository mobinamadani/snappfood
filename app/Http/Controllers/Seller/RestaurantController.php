<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Restaurant\CreateRequest;
use App\Http\Requests\seller\restaurant\DestroyRequest;
use App\Models\Admin\RestaurantCategory;
use App\Models\Seller\Restaurant;
use App\Models\Seller\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user_id = Auth::id();
        $restaurants = Restaurant::query()->where('seller_id', Auth::id())->get();
        return view('seller.restaurantIndex', compact('restaurants'));
    }

    public function create(int $sellerId): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $restaurantCategories = RestaurantCategory::all();
//        $sellers = Seller::all();
        return view('seller.resturantForm', compact('sellerId', 'restaurantCategories'));
    }

    public function store(CreateRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        Restaurant::query()->create($validated);
        return redirect(route('seller.dashboard'));
    }

    public function edit(Restaurant $restaurant): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $restaurantCategories = RestaurantCategory::all();
        return view('seller.restaurantEdit', compact('restaurant', 'restaurantCategories'));
    }

    public function update(Request $request, Restaurant $restaurant): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $restaurant->update($validated);
        return redirect(route('seller.restaurantIndex'));
    }

    public function destroy(DestroyRequest $request): \Illuminate\Http\RedirectResponse
    {
        Restaurant::query()->where('id' , $request->id)->delete();
        return back();
    }

}
