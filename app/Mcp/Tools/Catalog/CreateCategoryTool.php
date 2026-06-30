<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Models\Category;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateCategoryTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        Create a new category.
        Slug is auto-generated from name if not provided. Set parent_id to nest the category under an existing one.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        if (empty($data['slug'] ?? null) && ! empty($data['name'] ?? null)) {
            $data['slug'] = Str::slug($data['name']);
        }

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:160', 'regex:/^[a-z0-9-]+$/', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'icon' => ['nullable', 'string', 'max:80'],
            'position' => ['sometimes', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:320'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $category = Category::create($validator->validated());

        return Response::json([
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'parent_id' => $category->parent_id,
            'position' => $category->position,
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()->description('Display name')->required(),
            'slug' => $schema->string()->description('URL slug (auto from name if omitted). Lowercase + hyphens.'),
            'parent_id' => $schema->integer()->description('Parent category id for nesting'),
            'icon' => $schema->string()->description('Heroicon name (e.g. "bolt")'),
            'position' => $schema->integer()->description('Manual sort order (lower first; 0 = alphabetical default)'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description (≤320 chars)'),
        ];
    }
}
