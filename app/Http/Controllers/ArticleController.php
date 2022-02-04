<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\File;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $search=trim($req->search);
        if($search){
            $article=Article::title($search)->get();
            return view('article.index')->with('articles',$article);
            #return Article::where('title', 'LIKE', "%$search%")->get();
        }
        return view('article.index')->with('articles',Article::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
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
        $article= new Article;
        $article->title= $request->title;
        $article->descrip=$request->descrip;
         $article->save(); 
        $files=$request->file('files') ;

        foreach ($files as $file) {
            $newFile=new File;
            $newFile->article()->associate($article);
            $newFile->path=$file->store('public/docs');
            $newFile->save();
        }
        #return $files[0];
        return redirect(route('article.create'))->with('success','El articulo fue publicado con exito') ;
    }

    private function createValidator($data){
        return Validator::make($data,[
            'title'=> 'required|max:255',
            'descrip'=>'required|max:255',
            'files'=>'required',
            'files.*'=>['mimes:pdf']
           
        ],[
            'required'=>'Este Campo es Obligatorio',
            'mimes'=>'Solo se aceptan archivos en formato PDF'
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
        $article=Article::find($id);
        #return $article->files()->first();
        return view('article.show')->with('article',$article);
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
    public function destroy(Article $article)
    {
        //
    }
}
