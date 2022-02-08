<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Video;
use App\Models\File;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dawson\Youtube\Facades\Youtube;

class ArticleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $search = trim($req->search);
        if ($search) {
            $article = Article::title($search)->get();
            return view('article.index')->with('articles', $article);
            #return Article::where('title', 'LIKE', "%$search%")->get();
        }
        return view('article.index')->with('articles', Article::where('estado',true)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create')->with('cont', Video::whereDate('created_at', date('Y-m-d'))->count());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->createValidator($request->all())->validate();
        $article = new Article;
        $article->title = $request->title;
        $article->descrip = $request->descrip;
        $article->user()->associate(auth()->user());
        $article->save();
        $files = $request->file('files');


        if ($request->video) {
            if (Video::whereDate('created_at', date('Y-m-d'))->count() >= 4) {
                return redirect()->back()->with('overquote', 'Se ha superado la cantidad de videos que se pueden subir hoy. Porfavor intentelo mañana');
            }

            $video = new Video;
            $vid = Youtube::upload($request->file('video')->getPathName(), [
                'title'       => $request->input('title'),
                'description' => $request->input('descrip')
            ]); 
            $video->video_id = $vid->getVideoId();
            $video->article()->associate($article);
            $video->save();
        }

        foreach ($files as $file) {
            $newFile = new File;
            $newFile->article()->associate($article);
            $newFile->path = $file->store('public/docs');
            $newFile->save();
        }
        #return $files[0];
        return redirect(route('article.create'))->with('success', 'El articulo fue publicado con exito');
    }

    private function createValidator($data)
    {
        return Validator::make($data, [
            'title' => 'required|max:255',
            'descrip' => 'required|max:255',
            'files' => 'required | max:50000 ',
            'files.*' => 'mimes:pdf',
            'video.*'=>'required|mimes:mp4,avi,mov,mpeg-1,mpeg-2,mpeg4,mpeg,wmv,flv|max:100000',
            

        ], [
            'required' => 'Este Campo es Obligatorio',
            'mimes' => 'No se acepta este formato'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        #return $article->files()->first();
        return view('article.show')->with('article', $article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article=Article::find($id);
        $article->estado=false;
        $article->save();

        return redirect(route('article.index'));
    }
}
