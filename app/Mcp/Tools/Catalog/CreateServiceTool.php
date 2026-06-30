<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Mcp\Tools\Catalog\Concerns\InteractsWithServiceImages;
use App\Models\Service;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateServiceTool extends Tool
{
    use InteractsWithServiceImages;

    protected string $description = <<<'MARKDOWN'
        Create a new service within a category.
        Slug auto-generates from name if not provided.
        Pass `custom_fields` as an object (per-site schema: kVA/dB/fuel for generators, m³/lockable for containers, etc.).
        `additional_category_ids` are extra categories the service also appears in, besides its primary `category_id`.
        `images` is an optional array of public image URLs; each is downloaded and attached to the gallery.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        if (empty($data['slug'] ?? null) && ! empty($data['name'] ?? null)) {
            $data['slug'] = Str::slug($data['name']);
        }

        $validator = Validator::make($data, [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'additional_category_ids' => ['nullable', 'array'],
            'additional_category_ids.*' => ['integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:160'],
            'slug' => ['required', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', 'unique:services,slug'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'custom_fields' => ['nullable', 'array'],
            'is_active' => ['nullable', 'boolean'],
            'position' => ['nullable', 'integer', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['url'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $service = Service::create([
            ...$validator->safe()->except(['images', 'additional_category_ids']),
            'is_active' => $data['is_active'] ?? true,
            'position' => $data['position'] ?? 0,
        ]);

        $this->syncAdditionalCategories(
            $service,
            $validator->safe()->has('additional_category_ids') ? $validator->safe()->array('additional_category_ids') : null,
        );

        $images = $this->attachImages($service, $validator->safe()->array('images'));

        return Response::json([
            'id' => $service->id,
            'slug' => $service->slug,
            'name' => $service->name,
            'is_active' => $service->is_active,
            'images_attached' => $images['attached'],
            'image_errors' => $images['errors'],
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'category_id' => $schema->integer()->description('Primary category id')->required(),
            'additional_category_ids' => $schema->array()->description('Extra category ids the service also appears in'),
            'name' => $schema->string()->description('Service name')->required(),
            'slug' => $schema->string()->description('URL slug (auto from name if omitted)'),
            'short_description' => $schema->string()->description('One-line summary (≤255 chars)'),
            'description' => $schema->string()->description('Long description'),
            'custom_fields' => $schema->object()->description('Per-site custom attributes (kVA, dB, fuel…)'),
            'is_active' => $schema->boolean()->description('Defaults to true'),
            'position' => $schema->integer()->description('Sort order (lower appears first)'),
            'images' => $schema->array()->description('Public image URLs to download into the gallery'),
        ];
    }
}
