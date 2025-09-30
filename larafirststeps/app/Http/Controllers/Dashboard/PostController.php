<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = Post::get();
        //para agregar la pagina -->paginate
        //session(['key' => 'value']);
        session()->forget('key');
        //session(['key' => 'value']);
        //session(['key2' => 'value']);
        $posts = Post::paginate(2);
        return view('dashboard/post/index', compact('posts'));
        /*borrado
        $post = Post::find(1);
        $post->delete();*/
        /*actualizar
        $post = Post::find(1);
        $post->update(
            [
                'title' => 'test title',
                'slug' => 'test slug',
                'content' => 'test content',
                'image' => 'test image1',
            ]

        );*/

        /*Post::create(
            [
                'title' => 'test title',
                'slug' => 'test slug',
                'content' => 'test content',
                'category_id' => 1,
                'description' => 'test description',
                'posted' => 'not',
                'image' => 'test image',
            ]

        );*/
        //return 'Index';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('id', 'title');
        $post = new Post();

        return view('dashboard.post.create', compact('categories', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    //public function store(Request  $request)
    {
        //$validated = Validator::make($request->all(),
        //    [
        //        'title' => 'required|min:5|max:500',
        //        'slug' => 'required|min:5|max:500',
        //        'content' => 'required|min:7',
        //        'category_id' => 'required|integer',
        //        'description' => 'required|min:7',
        //        'posted' => 'required',
        //    ]
        //);
        
       //dd($validated->fails()); 
        Post::create($request->validated());
        return to_route('post.index')->with('status', 'Post created');

      //$request->validate([
      //     'title' => 'required|min:5|max:500',
      //      'slug' => 'required|min:5|max:500',
      //      'content' => 'required|min:7',
      //      'category_id' => 'required|integer',
      //      'description' => 'required|min:7',
      //      'posted' => 'required',
      // ]);

      //  echo 'not';
        //Post::create($request->all());
        //return to_route('post.index');
        //dd($request->all()['title']);
        /*Post::create(
            [
                'title' => $request->all()['title'],
                'slug' => $request->all()['slug'],
                'content' => $request->all()['content'],
                'category_id' => $request->all()['category_id'],
                'description' => $request->all()['description'],
                'posted' => $request->all()['posted'],
                //'image' => $request->all()['test image'],
            ]
            );*/
           // dd(request()->get('title'));
           
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard/post/show',['post'=> $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
       $categories  = Category::pluck('id', 'title');
       return view('dashboard.post.edit', compact('categories', 'post')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutRequest $request, Post $post)
    {
        $data = $request->validated();
        //dd($request->image);
        ///image
        if(isset($data['image']))
        {
            $data['image'] = $filename = time().'.'.$data['image']->extension();
            $request->image->move(public_path('uploads/posts'),$filename);
        }
        //image
        $post->update($data);
        return to_route('post.index')->with('status', 'Post update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index')->with('status', 'Post delete');
    }
}
