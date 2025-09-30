<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\PutRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        session(['key' => 'value']);
        $categories = Category::paginate(2);
        return view('dashboard.category.index', compact('categories'));
    }

    public function create()
    {
        $category = new Category();
        return view('dashboard.category.create', compact('category'));
    }

    public function store(StoreRequest $request)
    {
        Category::create($request->validated());
        $this->updateCategoriesJson(); // ✅ Actualiza el JSON después de crear

        return to_route('category.index')->with('status', 'Category created');
    }

    public function show(Category $category)
    {
        return view('dashboard.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('dashboard.category.edit', compact('category')); 
    }

    public function update(PutRequest $request, Category $category)
    {
        $category->update($request->validated());
        $this->updateCategoriesJson(); // ✅ Actualiza el JSON después de actualizar

        return to_route('category.index')->with('status', 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        $this->updateCategoriesJson(); // ✅ Actualiza el JSON después de eliminar

        return to_route('category.index')->with('status', 'Category deleted');
    }

    /**
     * ✅ Método privado para actualizar el archivo categories.json
     */
    private function updateCategoriesJson()
    {
        $categories = Category::all(['id', 'title', 'slug']); // Solo los campos necesarios
        $jsonPath = storage_path('app/categories.json'); // Ruta del archivo JSON

        file_put_contents($jsonPath, $categories->toJson(JSON_PRETTY_PRINT));
    }
}
