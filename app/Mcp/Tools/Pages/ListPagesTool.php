<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Pages;

use App\Models\Page;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class ListPagesTool extends Tool
{
    protected string $description = 'List editable static pages (legal, gracias, sobre nosotros…). Optionally filter by active state.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $pages = Page::query()
            ->when(array_key_exists('is_active', $data), fn ($q) => $q->where('is_active', (bool) $data['is_active']))
            ->orderBy('title')
            ->get(['id', 'slug', 'title', 'is_active', 'updated_at'])
            ->map(fn (Page $p): array => [
                'id' => $p->id,
                'slug' => $p->slug,
                'title' => $p->title,
                'is_active' => $p->is_active,
                'public_url' => url('/'.$p->slug),
                'updated_at' => $p->updated_at?->toIso8601String(),
            ])
            ->all();

        return Response::json(['pages' => $pages, 'count' => count($pages)]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'is_active' => $schema->boolean()->description('Filter by active state (omit for all)'),
        ];
    }
}
