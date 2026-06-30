<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Models\Category;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class ListCategoriesTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        List all categories in the catalog, in display order (position, then name).
        Returns each category's id, name, slug, parent_id (for the hierarchy), icon and position.
        Optionally filter by parent_id (use null to list roots only) or search by name substring.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $categories = Category::query()
            ->when(array_key_exists('parent_id', $data), fn ($q) => $q->where('parent_id', $data['parent_id']))
            ->when(! empty($data['search'] ?? null), fn ($q) => $q->where('name', 'like', '%'.$data['search'].'%'))
            ->ordered()
            ->get(['id', 'name', 'slug', 'parent_id', 'icon', 'position', 'meta_title', 'meta_description'])
            ->map(fn (Category $c): array => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'parent_id' => $c->parent_id,
                'icon' => $c->icon,
                'position' => $c->position,
                'meta_title' => $c->meta_title,
                'meta_description' => $c->meta_description,
            ])
            ->all();

        return Response::json(['categories' => $categories, 'count' => count($categories)]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'parent_id' => $schema->integer()
                ->description('Filter by parent_id (use null for roots; omit to list all)'),
            'search' => $schema->string()
                ->description('Substring search on the name'),
        ];
    }
}
