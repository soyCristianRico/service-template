<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Enums\LocationType;
use App\Models\Location;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class ListLocationsTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        List locations. Optionally filter by parent_id, type (country/region/province/city/district) or name substring.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $locations = Location::query()
            ->when(array_key_exists('parent_id', $data), fn ($q) => $q->where('parent_id', $data['parent_id']))
            ->when(! empty($data['type'] ?? null), fn ($q) => $q->where('type', $data['type']))
            ->when(! empty($data['search'] ?? null), fn ($q) => $q->where('name', 'like', '%'.$data['search'].'%'))
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'parent_id', 'type', 'population'])
            ->map(fn (Location $c): array => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'parent_id' => $c->parent_id,
                'type' => $c->type->value,
                'population' => $c->population,
            ])
            ->all();

        return Response::json(['locations' => $locations, 'count' => count($locations)]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'parent_id' => $schema->integer()->description('Filter by parent_id'),
            'type' => $schema->string()
                ->enum(array_map(fn (LocationType $t): string => $t->value, LocationType::cases()))
                ->description('Filter by location type'),
            'search' => $schema->string()->description('Substring search on the name'),
        ];
    }
}
