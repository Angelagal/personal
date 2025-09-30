*************************comando para  crear  un nuevo proyecto
composer create-project laravel/laravel blog
laravel new laravel
*************************comando para crear el controlador y el modelo
php artisan make:controller Dashboard/CategoryController -r --model=Category
************************migraciones
para posts
php artisan make:migration createPostsTable
$table->id();
$table->string('title',500);
$table->string('slug',500);
$table->string('description')->nullable();
$table->string('content')->nullable();
$table->string('image')->nullable();
$table->enum('posted', ['yes','not'])->default('not');
$table->enum('rol', ['regular', 'admin'])->default('regular');
$table->foreignId('category_id')->constrained()
->onDelete('cascade'):
$table->timestamps();

para categories
$table->id();
$table->string('title', 500);
$table->string('slug', 500);
********************************************Models
app/Models/Category.php
class Category extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['title','slug'];

    public function posts()
    {
        return $this->hasMany(Post:class);
    }

}
------------------------------------
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'content', 'category_id', 'description', 'posted', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
********************************************Controlador
app/http/Controllers/Dashboard/CategoryController.php
PostController.php 

php artisan make:controller Dashboard/CategoryController -r --model=CategoryController


public function index()
{
    session(['key' => 'value']);
    $categories = Category::paginate(10)   
    return view('dashboard.category.index', compact('categories'));   
}

public function create() {
    $category = new Category();
    return view('dashboard.category.create', compact('category'));
}

public function store(StoreRequest $request)
{
    Category::create($request->validated());
    $this->updateCategoriesJson();

    return to_route('category.index')->with('status', 'Categoria creada');
}

public function show(Category $category)
{
    return view('dashboard.category.show', compact('category'));
}

public function edit(Category $category)
{
    return view('dashboard.category.edit', compact('category'));
}




private function updateCategoriesJson()
{
    $categories=Category::all([]);
    $jsonPath=storage_path('app/catgeories.json');
    file_put_contents($jsonPath, $categories->toJson(JSON_PRETTY_PRINT));
}

******************************************************Rutas
Route::get('/', function() {
return view('welcome');
});

Route::group(['prefix' => 'dashboard'], function() {
    Route::resource('post', PostController::class);
    Route::resource('category', CategoryController::class);
        Route::resources{
            [
                'post'=> PostController::class,
                'category' => CategoryController::class,
                ]
        }:

});
***********************************************************Vistas
resources/views/dashboard/

master.blade.php

<style>
body{
display:flex;
min-height: 100vh;
}
aside{
width:250px;
background-color:#343a40;
color: white;
padding:20px;
}
aside a{
color:white;
text-decoration:none;
display:block;
margin: 10px 0;
}
aside a:hover {
color:#0d6efd;
}
main {
flex:1;
padding:20px;
background-color:#f8f9fa;
}
.active{
background-color:#0d6efd;
padding:10px;
border-radius:5px;
}
</style>
<body>
<aside>
<h4>Formulario</h4>
<p>Usuario</p>
<a href="{{ url('/dashboard/post') }}" class="active">Post</a>
<a href="{{ url('/dashboard/category') }}">Categoria</a>
<a href="{{ url('/') }}" style="color: #dc3545;">Salir</a>
</aside>
<main>
@if(session('status'))
<div class="alert alert-info">
{{ session('status') }}
</div>
@endif
@yield('content')
</main>
</body>


*****resources/views/dashboard/category
_form.blade.php

@csrf
<label for="post/store">Title</label>
<input type="text" name="title" value="{{ old('title', $category->title)}}">

<label for="">Slug</label>
<input type="text" name="slug" value="{{ old('slug', $category->slug) }}">


<button type="submit>Send</button>

*****resources/views/dashboard/category/
create.blade.php

@extends('dashboard.master')

@section('content')

	@include('dashboard.fragment._errors-form')
	
	<form action="{{ route('category.store') }}" method="post">
		@include('dashboard.category._form')
	</form>

@endsection
-------------------------------/post/_form.blade.php

@csrf

<label for="post/store">Title</label>
<input type="text" name="title" value="{{ old('title', $post->title) }}">
<label for="">Slug</label>
<input type="text" name="slug" value="{{ old('slug', $post->slug) }}">
<label for="">Content</label>
<textarea name="content">{{ old('content', $post->content) }}</textarea>
<label for="">Category</label>
<select name="category_id">
    @foreach ($categories as $title => $id)
        <option {{ old('category_id', $post->category_id) == $id ? 'selected' : ''}} value="{{$id}}">{{$title}}</option>
    @endforeach
</select>
<label for="">Description</label>
<textarea name="description">{{old('description', $post->description)}}</textarea>

<label for="">Posted</label>
<select name="posted">
    <option {{ old('posted', $post->posted) == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
    <option {{ old('posted', $post->posted) == 'not' ? 'selected' : '' }} value="not">Not</option>
</select>

@if (isset($task) && $task == 'edit')
    <label for="">Image</label>
    <input type="file" name="image">
@endif

<button type="submit">Send</button>

*****resources/views/dashboard/category/
edit.blade.php

@extends('dashboard.master')

@section('content')

	@include('dashboard.fragment._errors-form')
	
	<form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
		
	@method('PATCH')
		@include('dashboard.category._form', ['task' => 'edit'])
	</form>

@endsection


*****resources/views/dashboard/category/
show.blade.php

@extends('dashboard.master')
@section('content')
<h1>{{ $post->title }}</h1>
@endsection


*****resources/views/dashboard/category/
index.blade.php

@extends('dashboard.master')
@section('content')

<a href="{{ route('category.create') }}" target="blank">Create</a>

<table>
	<thead>
		<tr>
		<td>Id</td>
		<td>Title</td>
		<td>Options</td>
		</tr>
		<tbody>
			@foreach ($categories as $c)
			<tr>
				<td>
					{{ $c->id }}
				</td>
				<td>
				{{ $c->title }}
				</td>
				<td>
					<a href="{{ route('category.edit', $c) }}">Edit</a>
					<a href="{{ route('category.show', $c) }}">Show</a>
					<form action="{{ route('category.destroy', $c) }}" method="post">
					 @method('DELETE')
					 @csrf
					 <button type="submit">Delete</button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</thead>
</table>

{{ $categories->links() }}
@endsection


