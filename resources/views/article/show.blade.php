@extends('layouts.navbar')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@section('public')
    <div class="container border" >
        <div class="container-fluid p-3">
            <h3>{{ $article->title }}</h3>

            <p style="width: 50%">{{ $article->descrip }}</p>
        </div>

        @if ($article->files)
            @foreach ($article->files as $file)
                <div class="mb-5 p-3">


                    <div class="ratio ratio-16x9 border">
                        <iframe class="" src="{{asset(Storage::url($file->path))}}"></iframe>
                        
                    </div>
                </div>
            @endforeach

        @endif

    </div>

@endsection
