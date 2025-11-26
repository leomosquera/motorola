{{-- Extends layout --}}
@extends('layout.clear')

{{-- Content --}}
@section('content')

    {{-- Dashboard 1 --}}

    <div class="row pl-5 pr-5 pt-5 pb-5">
        <div class="col-12">
            @foreach($info as $dealer)
                <h1 class="mt-5" style="font-size: 2.5rem; color: #3f5bb6">{{ $dealer['name'] }}</h1>
                <hr>
                @foreach($dealer['stores'] as $store)
                    <strong><a class="mt-2" target="_blank" style="font-size: 1.5rem;" href="{{ $store['url'] }}">{{ '('.$store['code'].') '.$store['name'] }}</a></strong><br>
                @endforeach
            @endforeach
        </div>
    </div>

@endsection

