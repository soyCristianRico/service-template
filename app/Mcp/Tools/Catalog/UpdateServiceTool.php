<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Mcp\Tools\Catalog\Concerns\InteractsWithServiceImages;
use App\Models\Service;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class UpdateServiceTool extends Tool
{
    use InteractsWithServiceImages;

    protected string $description = <<<'MARKDOWN'
        Update an existing service. Provide id + any subset of fields.
        `custom_fields` replaces the whole jsonb blob (not merged). Pass the full object you want stored.
        `additional_category_ids` are extra categories the service also appears in (besides its primary
        `category_id`); passing it replaces the whole set, omitting it leaves it untouched.
        `images` (array of public URLs) are appended to the gallery; set `replace_images=true` to clear first.
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => ['required', 'integer', 'exists:services,id'],
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
            'additional_category_ids' => ['sometimes', 'array'],
            'additional_category_ids.*' => ['integer', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:160'],
            'slug' => ['sometimes', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', Rule::unique('services', 'slug')->ignore($data['id'] ?? null)],
            'short_description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'custom_fields' => ['sometimes', 'nullable', 'array'],
            'is_active' => ['sometimes', 'boolean'],
            'position' => ['sometimes', 'integer', 'min:0'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['url'],
            'replace_images' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->safe()->except(['id', 'additional_category_ids', 'images', 'replace_images']);
        $service = Service::findOrFail($data['id']);
        $service->update($valid);

        $this->syncAdditionalCategories(
            $service,
            $validator->safe()->has('additional_category_ids') ? $validator->safe()->array('additional_category_ids') : null,
        );

        $images = ['attached' => 0, 'errors' => []];
        if ($validator->safe()->has('images')) {
            if ($data['replace_images'] ?? false) {
                $service->clearMediaCollection('gallery');
            }
            $images = $this->attachImages($service, $validator->safe()->array('images'));
        }

        return Response::json([
            'id' => $service->id,
            'slug' => $service->slug,
            'name' => $service->name,
            'category_id' => $service->category_id,
            'additional_category_ids' => $service->additionalCategories()->pluck('categories.id')->all(),
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
            'id' => $schema->integer()->description('Service id')->required(),
            'category_id' => $schema->integer()->description('Move to a different primary category'),
            'additional_category_ids' => $schema->array()->description('Extra category ids the service also appears in (replaces the whole set; omit to leave untouched)'),
            'name' => $schema->string()->description('Service name'),
            'slug' => $schema->string()->description('URL slug'),
            'short_description' => $schema->string()->description('One-line summary'),
            'description' => $schema->string()->description('Long description'),
            'custom_fields' => $schema->object()->description('Replace the whole custom_fields blob'),
            'is_active' => $schema->boolean()->description('Public visibility'),
            'position' => $schema->integer()->description('Sort order'),
            'images' => $schema->array()->description('Public image URLs to append to the gallery'),
            'replace_images' => $schema->boolean()->description('Clear the gallery before attaching new images'),
        ];
    }
}
