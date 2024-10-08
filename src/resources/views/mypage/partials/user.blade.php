<p class="user__name">{{ Auth::user()->name }}さん</p>
<div class="mypage__wrap">
    <div class="reservation__wrap">
        <div class="reservation__tab">
            <label class="reservation__title hover__color--blue">
                <input type="radio" name="tab" class="reservation__title-input" checked>
                予約状況
            </label>
            <div class="reservation__content-wrap">
                @foreach ($reservations as $reservation)
                    <div class="reservation__content">
                        
                        <table class="reservation__table">
                            <tr>
                                <th class="table__header">Shop</th>
                                <td class="table__item">{{ $reservation->shop->name }}</td>
                            </tr>
                            <tr>
                                <th class="table__header">Date</th>
                                <td class="table__item">{{ $reservation->date }}</td>
                            </tr>
                            <tr>
                                <th class="table__header">Time</th>
                                <td class="table__item">{{ date('H:i',strtotime($reservation->time)) }}</td>
                            </tr>
                            <tr>
                                <th class="table__header">Number</th>
                                <td class="table__item">{{ $reservation->number }}人</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>

            
            <label class="reservation__title hover__color--orange mobile-favorite__title">
                <input type="radio" name="tab" class="reservation__title-input">お気に入り店舗
            </label>
            <div class="reservation__content-wrap mobile-favorite__wrap">
                @foreach ($shops as $shop)
                    <div class="shop__content">
                        <img class="shop__image" src="{{ $shop->image_url }}" alt="イメージ画像">
                        <div class="shop__item">
                            <span class="shop__title">{{ $shop->name }}</span>
                            <div class="shop__tag">
                                <p class="shop__tag-info">#{{ $shop->area->name }}</p>
                                <p class="shop__tag-info">#{{ $shop->genre->name }}</p>
                            </div>
                            <div class="shop__button">
                                <a href="/detail/{{ $shop->id }}?from=mypage" class="shop__button-detail">詳しくみる</a>
                                @if(in_array($shop->id,$favorites))
                                    <form action="{{ route('unfavorite',$shop) }}" method="post" class="shop__button-favorite">
                                        @csrf
                                        @method('delete')
                                            <button type="submit" class="shop__button-favorite-btn" title="お気に入り削除">
                                                <img class="favorite__btn-image" src="{{ asset('images/heart_color.svg') }}">
                                            </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

