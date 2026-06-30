<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Models\Landing;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class GetLandingTool extends Tool
{
    protected string $description = 'Get the full record of one Landing by id, including content sections (jsonb).';

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $landing = Landing::with(['category', 'location'])->find($data['id']);

        if (! $landing instanceof Landing) {
            return Response::error("Landing not found with ID: {$data['id']}");
        }

        return Response::json([
            'id' => $landing->id,
            'slug' => $landing->slug,
            'category_id' => $landing->category_id,
            'category' => $landing->category?->name,
            'location_id' => $landing->location_id,
            'location' => $landing->location?->name,
            'title' => $landing->title,
            'meta_description' => $landing->meta_description,
            'content' => $landing->content,
            'status' => $landing->status->value,
            'publish_at' => $landing->publish_at?->toIso8601String(),
            'public_url' => url('/'.$landing->slug),
            'updated_at' => $landing->updated_at?->toIso8601String(),
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Landing id')->required(),
        ];
    }
}
