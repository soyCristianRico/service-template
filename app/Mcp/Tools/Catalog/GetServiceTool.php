<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Models\Service;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class GetServiceTool extends Tool
{
    protected string $description = 'Get a single Service by id, including full description and custom_fields.';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, ['id' => ['required', 'integer']]);
        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $service = Service::with(['category', 'additionalCategories:id,name'])->find($data['id']);
        if (! $service instanceof Service) {
            return Response::error("Service not found with ID: {$data['id']}");
        }

        return Response::json([
            'id' => $service->id,
            'slug' => $service->slug,
            'name' => $service->name,
            'category_id' => $service->category_id,
            'category' => $service->category?->name,
            'additional_category_ids' => $service->additionalCategories->pluck('id')->all(),
            'additional_categories' => $service->additionalCategories->pluck('name')->all(),
            'short_description' => $service->short_description,
            'description' => $service->description,
            'custom_fields' => $service->custom_fields,
            'images' => $service->getMedia('gallery')->map(fn ($media) => $media->getUrl())->all(),
            'is_active' => $service->is_active,
            'position' => $service->position,
            'updated_at' => $service->updated_at?->toIso8601String(),
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Service id')->required(),
        ];
    }
}
