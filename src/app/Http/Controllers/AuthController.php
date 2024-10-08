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

class AuthController extends Controller
{
/*    public function index()
{
  return view('login');
}*/

/*
public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = Hash::make($request->password);
        $user->save();

        $user->assignRole('writer');

        return view('admin.done');
    }*/

    /* public function store(RegisterRequest $request) */
    /* public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]); */

        /* return redirect('/register')->with('message','会員登録が完了しました'); */
        /* return redirect('/thanks')->with('message','会員登録が完了しました');
        return redirect('/auth.thanks');
    }*/

    public function postRegister(RegisterRequest $request)
    {
        try {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            /* return redirect('login'); */
            return view('auth.thanks');
        } catch (\Throwable $th) {
            return redirect('register');
        }
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $shops = $this->searchShops($request);
            $areas = Area::all();
            $genres = Genre::all();
            $favorites = $this->getFavorites();
           /* return redirect('/'); */
           return view('index',compact('shops', 'areas', 'genres', 'favorites'));
        } else {
            return redirect('login');
        }
    }

    private function searchShops(LoginRequest $request): \Illuminate\Support\Collection
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




    public function index()
    {
        $reservations = $this->getReservationsByStatus('予約');

        $favorites = Auth::user()->favorites()
            ->pluck('shop_id')
            ->toArray();

        $shops = Shop::with(['area', 'genre'])
            ->whereIn('id', $favorites)
            ->get();

        $user = Auth::user();
        $viewData = [
            'user' => $user,
            'reservations' => $reservations,
           
            'favorites' => $favorites,
            'shops' => $shops
        ];

        
            $viewData['roleView'] = 'mypage';
        

        return view('mypage', $viewData);
    }

    private function getReservationsByStatus($status)
    {
        return Auth::user()->reservations()
            ->where('status', $status)
            ->with('shop')
           /* ->orderBy('date', $status === '予約' ? 'asc' : 'desc')
            ->orderBy('time', $status === '予約' ? 'asc' : 'desc') */
            ->get();
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
