@extends('layouts.navbar')

@section('public')
    <div class="container">
        <div class="card text-start|center|end">
 
            <div class="card-body">

                <form id="fileUpload" action="" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Titulo</label>
                        <input type="text" value="{{ $article->title }}"
                            class="form-control @error('title') is-invalid @enderror "
                            id="title" name="title" placeholder="Titulo">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea  class="form-control @error('descrip') is-invalid  @enderror" name="descrip" id="descripcion" rows="3">
                        {{ $article->descrip }}
                        </textarea>
                        @error('descrip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 mt-4">


                        <label for="formFile" class="form-label">Archivos</label>
                        <div class="mb-4 mt-2">
                            @if ($article->files)
                            
                                <ul id="filesList" style="list-style: none;">



                                    @foreach ($article->files as $file)
                                        <li>


                                            <div class="input-group mb-3">
                                                <div class="form-control">
                                                    {{ $file->original_name }}
                                                </div>
                                                <button form="deleteFile" class="btn btn-outline-danger" type="submit"><i
                                                        class="bi bi-eraser-fill"></i></button>
                                            </div>

                                            <form id="deleteFile" action="{{ route('file.delete', $file->id) }}" method="post"> @csrf </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <input
                            class="form-control @error('files')
                            is-invalid
                        @enderror "
                            name="files[]" accept=".pdf" type="file" id="formFile" multiple>
                        <small class="form-text">Solo formato PDF</small>
                        @error('files')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror


                    </div>

                    <div class="mb-3">
                        @if ($cont < 4)
                            <label for="formFile" class="form-label">Video</label>
                            <small class="form-text">opcional</small>
                            <input class="form-control" type="file" accept=".mp4, .mov ,.avi, .wmv, .flv" name="video" />
                            <small class="form-text">Solo formatos .mp4 .avi .mov .mpeg .wmv .flv</small>
                        @else
                            <label for="formFile" class="form-label">Video</label>
                            <input class="form-control" disabled
                                placeholder="Limite de subidas alcanzado. Intententelo Mañana" />
                        @endif
                    </div>

                </form>
            </div>
            <div class="card-footer bg-white text-end border-0">
                <button class="btn btn-dark" form="fileUpload" type="submit">Subir</button>
               <a href="{{ route('article.show', ['id'=>$article->id]) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>

        
            
       

    </div>


@endsection
