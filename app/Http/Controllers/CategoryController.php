<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $categories = Category::withCount('tasks')->paginate(10);
        return view('categories.indexxxx', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->categoryService->createCategory($request->validated());
            return redirect()->route('categories.index')
                             ->with('success', 'Category created successfully!');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['color' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->validated());
        return redirect()->route('categories.index')
                         ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        try {
            $this->categoryService->deleteCategory($category);
            return redirect()->route('categories.index')
                             ->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}