<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Enums\LocationType;
use App\Models\Location;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateLocationTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        Create a new location. Slug auto-generates from name if not provided.
        Set parent_id and type to position in the hierarchy (country > region > province > city > district).
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        if (empty($data['slug'] ?? null) && ! empty($data['name'] ?? null)) {
            $data['slug'] = Str::slug($data['name']);
        }

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:160', 'regex:/^[a-z0-9-]+$/', 'unique:locations,slug'],
            'type' => ['required', Rule::enum(LocationType::class)],
            'parent_id' => ['nullable', 'integer', 'exists:locations,id'],
            'population' => ['nullable', 'integer', 'min:0', 'max:99999999'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:320'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $location = Location::create($validator->validated());

        return Response::json([
            'id' => $location->id,
            'name' => $location->name,
            'slug' => $location->slug,
            'parent_id' => $location->parent_id,
            'type' => $location->type->value,
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()->description('Display name')->required(),
            'slug' => $schema->string()->description('URL slug (auto from name if omitted)'),
            'type' => $schema->string()
                ->enum(array_map(fn (LocationType $t): string => $t->value, LocationType::cases()))
                ->description('country, region, province, city or district')
                ->required(),
            'parent_id' => $schema->integer()->description('Parent location id for nesting'),
            'population' => $schema->integer()->description('Population estimate'),
            'latitude' => $schema->number()->description('Latitude (-90..90)'),
            'longitude' => $schema->number()->description('Longitude (-180..180)'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description (≤320 chars)'),
        ];
    }
}
