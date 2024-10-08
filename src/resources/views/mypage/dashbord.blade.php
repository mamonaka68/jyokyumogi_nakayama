@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mypage_user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials.css') }}">
@endsection




@section('content')
    @if (isset($roleView))
        @include($roleView,['user' => $user])
    @else
        @include('partials.user',['reservations'=>$reservations,'histories'=>$histories,'shops'=>$shops])
    @endif
    <script src="{{ asset('js/reservation.js') }}"></script>
@endsection