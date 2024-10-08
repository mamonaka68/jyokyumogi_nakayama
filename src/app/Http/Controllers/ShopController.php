<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ShopController extends Controller
{
    public function index(Request $request)
    {
        
        $shops = $this->searchShops($request);
        $areas = Area::all();
        $genres = Genre::all();
        $favorites = $this->getFavorites();

        return view('index', compact('shops', 'areas', 'genres', 'favorites'));
    }

    private function searchShops(Request $request): \Illuminate\Support\Collection
    {
        $area = $request->input('area');
        $genre = $request->input('genre');
        $word = $request->input('word');

        $query = Shop::with(['area', 'genre'])
            ->when($area, function ($query) use ($area) {
                return $query->where('area_id', $area);
            })
            ->when($genre, function ($query) use ($genre) {
                return $query->where('genre_id', $genre);
            })
            ->when($word, function ($query) use ($word) {
                return $query->where('name', 'like', '%' . $word . '%');
            });

        return $query->get();
    }

    private function getFavorites(): array
    {
        if (Auth::check()) {
            return Auth::user()->favorites()->pluck('shop_id')->toArray();
        }
        return [];
    }
    public function detail(Request $request)
    {
        $user = Auth::user();
        $userId = Auth::id();
        $shop = Shop::find($request->shop_id);
        
        $from = $request->input('from');

        
        $countFavorites = Favorite::where('shop_id', $shop->id)->count();

        $backRoute = '/';
        switch ($from) {
            case 'index':
                $backRoute = '/';
                break;
            case 'mypage':
                $backRoute = '/mypage';
                break;
        }
        return view('detail', compact('user', 'shop', 'countFavorites', 'backRoute'));
    }
}
