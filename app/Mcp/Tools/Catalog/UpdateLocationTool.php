<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Enums\LocationType;
use App\Models\Location;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class UpdateLocationTool extends Tool
{
    protected string $description = 'Update an existing location. Provide id + the fields to change.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => ['required', 'integer', 'exists:locations,id'],
            'name' => ['sometimes', 'string', 'max:120'],
            'slug' => ['sometimes', 'string', 'max:160', 'regex:/^[a-z0-9-]+$/', Rule::unique('locations', 'slug')->ignore($data['id'] ?? null)],
            'type' => ['sometimes', Rule::enum(LocationType::class)],
            'parent_id' => ['sometimes', 'nullable', 'integer', 'exists:locations,id', Rule::notIn([$data['id'] ?? null])],
            'population' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:99999999'],
            'latitude' => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
            'meta_title' => ['sometimes', 'nullable', 'string', 'max:160'],
            'meta_description' => ['sometimes', 'nullable', 'string', 'max:320'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->validated();
        $location = Location::findOrFail($valid['id']);
        unset($valid['id']);
        $location->update($valid);

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
            'id' => $schema->integer()->description('Location id to update')->required(),
            'name' => $schema->string()->description('Display name'),
            'slug' => $schema->string()->description('URL slug'),
            'type' => $schema->string()
                ->enum(array_map(fn (LocationType $t): string => $t->value, LocationType::cases()))
                ->description('country/region/province/city/district'),
            'parent_id' => $schema->integer()->description('Parent location id (null = root)'),
            'population' => $schema->integer()->description('Population estimate'),
            'latitude' => $schema->number()->description('Latitude'),
            'longitude' => $schema->number()->description('Longitude'),
            'meta_title' => $schema->string()->description('SEO title override'),
            'meta_description' => $schema->string()->description('SEO meta description'),
        ];
    }
}
