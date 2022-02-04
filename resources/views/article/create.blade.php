@extends('layouts.navbar')

@section('public')
    <div class="container">
        <div class="card text-start|center|end">
          @if (session('success'))
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading"></h4>
            <p>{{session('success')}}</p>
          
          </div>
              
          @endif
            <div class="card-body">

                <form id="fileUpload" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Titulo</label>
                        <input type="text"
                            class="form-control @error('title') is-invalid
                            
                        @enderror "
                            id="title" name="title" placeholder="Titulo">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea
                            class="form-control @error('descrip') is-invalid
                            
                        @enderror"
                            name="descrip" id="descripcion" rows="3"></textarea>
                        @error('descrip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        
                        <label for="formFile" class="form-label">Archivos</label>
                        <input class="form-control @error('files')
                            is-invalid
                        @enderror " name="files[]"  type="file" id="formFile" multiple >
                        <small class="form-text">Solo formato PDF</small>
                        @error('files')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer bg-white text-end border-0">
                <button class="btn btn-dark" form="fileUpload" type="submit">Subir</button>
                <button form="fileUpload" class="btn btn-secondary" type="reset">reset</button>
            </div>
        </div>

    </div>
@endsection
