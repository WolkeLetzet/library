@extends('layouts.navbar')

@section('public')

        <div class="row   row-cols-lg-3 row-cols-lg-4row-cols-lg-2 g-2 g-lg-3 ">

            @foreach ($articles as $article)
                <div class="col mb-3">

                    <div class="card " style="height: 100%">
                        @hasrole('admin')
                        <div class="card-header bg-white">
                            <form method="POST" action="{{ route('article.delete', $article->id) }}">
                                @csrf
                                <div class="text-end">
                                    <button type="submit" class="btn-close" aria-label="Close"></button>
                                </div>
                                
                            </form>
                        </div>
                        @endhasrole
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ $article->descrip }}</p>

                        </div>
                        <div class="card-footer text-end bg-white border-top-0">
                            <a href="{{ route('article.show', ['id'=>$article->id]) }}">Ver mas >></a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endsection
