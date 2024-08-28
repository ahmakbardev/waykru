@extends('layouts.layout')

@section('assets')
    <link rel="stylesheet" href="{{ asset('assets/social/styles-social/footersocial.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/social/styles-social/general.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/social/styles-social/page-1social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/social/styles-social/socialheader.css') }}">
@endsection
@section('content')
    <div class="page-1-social">
        <div class="page-1-title-social">
            <h1>Social Broadcast</h1>
        </div>

        <div class="grid-container">
            <div class="grid-item">
                <img src="{{ asset('assets/social/images-social/placeholdersocial1.jpg')}}" alt="Image 1">
                <h2>Tim Seni Wayang Krucil Malangan</h2>
                <p>256 Followers 7.003 Likes</p>
                <a href="">Follow</a>
            </div>

            <div class="grid-item">
                <img src="{{ asset('assets/social/images-social/placeholdersocial2.jpg')}}" alt="Image 1">
                <h2>Tim Seni Wayang Krucil Tuban</h2>
                <p>112 Followers 6.402 Likes</p>
                <a href="">Follow</a>
            </div>

            <div class="grid-item">
                <img src="{{ asset('assets/social/images-social/palceholdersocial3.webp')}}" alt="Image 1">
                <h2>Tim Seni Wayang Krucil Kediri</h2>
                <p>432 Followers 9.710 Likes</p>
                <a href="">Follow</a>
            </div>
        </div>
    </div>
@endsection
