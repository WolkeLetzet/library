@foreach ($files as $file )
    <div> {{$file->getMimeType()}}</div>
@endforeach