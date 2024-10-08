@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
    <form class="header__right" action="/" method="get">

        <div class="header__search">
            <label class="select-box__label">
                <select name="area" class="select-box__item">
                    <option value="">All area</option>
                    @foreach ($areas as $area)
                        <option class="select-box__option" value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area->region }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="select-box__label">
                <select name="genre" class="select-box__item">
                    <option value="">All genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->category }}</option>
                    @endforeach
                </select>
            </label>

            <div class="search__item">
                <div class="search__item-button"></div>
                <label class="search__item-label">
                    <input type="text" name="word" class="search__item-input" placeholder="Search ..." value="{{ request('word') }}">
                </label>
            </div>

        </div>
    </form>


@endsection

@section('content')
    <div class="shop__wrap">
        @foreach ($shops as $shop)
            <div class="shop__content">
                <img class="shop__image" src="{{ $shop->url_info }}" alt="イメージ画像">
                <div class="shop__item">
                    <span class="shop__title">{{ $shop->shop_name }}</span>
                    <div class="shop__tag">
                        <p class="shop__tag-info">#{{ $shop->area->region }}</p>
                        <p class="shop__tag-info">#{{ $shop->genre->category }}</p>
                    </div>
                    <div class="shop__button">
                        <a href="/detail/{{ $shop->id }}?from=index" class="shop__button-detail">詳しくみる</a>
                        
                            @if (in_array($shop->id, $favorites))
                                <form action="{{ route('unfavorite', $shop) }}" method="post"
                                    enctype="application/x-www-form-urlencoded" class="shop__button-favorite form">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="shop__button-favorite-btn" title="お気に入り削除">
                                        <img class="favorite__btn-image" src="{{ asset('images/heart_color.svg') }}">
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('favorite', $shop) }}" method="post"
                                    enctype="application/x-www-form-urlencoded" class="shop__button-favorite form">
                                    @csrf
                                    <button type="submit" class="shop__button-favorite-btn" title="お気に入り追加">
                                        <img class="favorite__btn-image" src="{{ asset('images/heart.svg') }}">
                                    </button>
                                </form>
                            @endif
                        
                    </div>
                </div>
            </div>
        @endforeach


    </div>
@endsection