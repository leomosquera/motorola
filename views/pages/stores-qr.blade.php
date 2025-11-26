{{-- Extends layout --}}
@extends('layout.clear')

{{-- Content --}}
@section('content')

    {{-- Dashboard 1 --}}

    <div class="row p-10 mr-0 ml-0">
        <div class="col-12">
            <div class="row mt-5">
                @foreach($info_store as $store)
                    <div class="col-12 col-md-6 col-lg-4 text-center mb-30">
                        <h2>{{ $store['name'] }}</h2>
                        <h5>{{ $store['code'] }}</h5>
                        <img class="img-thumbnail mt-2 mb-2" src="{{ url('storage/img/qr-code/'.$store['image']) }}" width="150" height="150" style="margin-top: 20px"><br>
                        <a href="{{ url('storage/img/qr-code/'.$store['image']) }}" class="btn btn-primary" download>Download</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

