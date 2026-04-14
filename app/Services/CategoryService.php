<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function createCategory(array $data): Category
    {
        $this->validateColor($data['color'] ?? '#6366f1');

        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        if (isset($data['color'])) {
            $this->validateColor($data['color']);
        }

        $category->update($data);
        return $category->fresh();
    }

    public function deleteCategory(Category $category): bool
    {
        if ($category->tasks()->exists()) {
            throw new \Exception('Cannot delete category that has tasks.');
        }

        return $category->delete();
    }

    private function validateColor(string $color): void
    {
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
            throw new \InvalidArgumentException('Invalid color format. Use hex format like #FF5733.');
        }
    }
}