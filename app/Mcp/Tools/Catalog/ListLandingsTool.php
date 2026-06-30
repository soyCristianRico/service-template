<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Models\Landing;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class ListLandingsTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        List landings, the (category × optional location) combinations published as pages.
        Filter by category_id, location_id, status (draft | scheduled | published), or slug substring.
        Use status=draft to find unscheduled landings and status=scheduled to review what is queued.
        Returns slug, category/location ids and names, status, publish_at, title/meta overrides if set.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $landings = Landing::query()
            ->with(['category:id,name,slug', 'location:id,name,slug'])
            ->when(! empty($data['category_id'] ?? null), fn ($q) => $q->where('category_id', $data['category_id']))
            ->when(array_key_exists('location_id', $data), fn ($q) => $data['location_id'] === null
                ? $q->whereNull('location_id')
                : $q->where('location_id', $data['location_id']))
            ->when(! empty($data['status'] ?? null), fn ($q) => $q->where('status', $data['status']))
            ->when(! empty($data['search'] ?? null), fn ($q) => $q->where('slug', 'like', '%'.$data['search'].'%'))
            ->orderByDesc('updated_at')
            ->limit($data['limit'] ?? 100)
            ->get()
            ->map(fn (Landing $l): array => [
                'id' => $l->id,
                'slug' => $l->slug,
                'category_id' => $l->category_id,
                'category' => $l->category?->name,
                'location_id' => $l->location_id,
                'location' => $l->location?->name,
                'status' => $l->status->value,
                'publish_at' => $l->publish_at?->toIso8601String(),
                'title' => $l->title,
                'meta_description' => $l->meta_description,
                'updated_at' => $l->updated_at?->toIso8601String(),
            ])
            ->all();

        return Response::json(['landings' => $landings, 'count' => count($landings)]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'category_id' => $schema->integer()->description('Filter by category id'),
            'location_id' => $schema->integer()->description('Filter by location id'),
            'status' => $schema->string()->description('Filter by status: draft | scheduled | published'),
            'search' => $schema->string()->description('Substring search on the slug'),
            'limit' => $schema->integer()->description('Max rows (default 100)'),
        ];
    }
}
