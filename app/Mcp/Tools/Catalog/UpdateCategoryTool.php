<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Models\Category;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class UpdateCategoryTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        Update an existing category. Provide id + the fields to change.
        Setting parent_id to null detaches the category from its current parent (becomes a root).
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:120'],
            'slug' => ['sometimes', 'string', 'max:160', 'regex:/^[a-z0-9-]+$/', Rule::unique('categories', 'slug')->ignore($data['id'] ?? null)],
            'parent_id' => ['sometimes', 'nullable', 'integer', 'exists:categories,id', Rule::notIn([$data['id'] ?? null])],
            'icon' => ['sometimes', 'nullable', 'string', 'max:80'],
            'position' => ['sometimes', 'integer', 'min:0'],
            'meta_title' => ['sometimes', 'nullable', 'string', 'max:160'],
            'meta_description' => ['sometimes', 'nullable', 'string', 'max:320'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->validated();
        $category = Category::findOrFail($valid['id']);
        unset($valid['id']);
        $category->update($valid);

        return Response::json([
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'parent_id' => $category->parent_id,
            'icon' => $category->icon,
            'position' => $category->position,
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Category id to update')->required(),
            'name' => $schema->string()->description('Display name'),
            'slug' => $schema->string()->description('URL slug'),
            'parent_id' => $schema->integer()->description('Parent category id (null = root)'),
            'icon' => $schema->string()->description('Heroicon name'),
            'position' => $schema->integer()->description('Manual sort order (lower first; 0 = alphabetical default)'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description (≤320 chars)'),
        ];
    }
}
