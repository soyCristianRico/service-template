<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog;

use App\Enums\LandingStatus;
use App\Models\Landing;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Validator;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class BulkCreateLandingsTool extends Tool
{
    protected string $description = <<<'MARKDOWN'
        Bulk-create landings from the cross-service of `category_ids` × `location_ids`.
        Use this to spin up dozens of combinations at once. Per combination:
        - If the (category_id, location_id) already exists: leave as-is (unless `activate_existing` is true, which publishes non-published ones).
        - If it doesn't exist: create it with status=published and auto-built slug.
        Pass `include_category_only=true` to also create one category-only landing per category.
        Returns counts (created, reactivated, skipped).
    MARKDOWN;

    public function handle(Request $request): Response
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'category_ids' => ['required', 'array', 'min:1'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
            'location_ids' => ['nullable', 'array'],
            'location_ids.*' => ['integer', 'exists:locations,id'],
            'include_category_only' => ['nullable', 'boolean'],
            'activate_existing' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return Response::error('Validation failed: '.implode(', ', $validator->errors()->all()));
        }

        $valid = $validator->validated();
        $categoryIds = $valid['category_ids'];
        $locationIds = $valid['location_ids'] ?? [];
        $includeCategoryOnly = (bool) ($valid['include_category_only'] ?? false);
        $activateExisting = (bool) ($valid['activate_existing'] ?? false);

        // Cross-service target combinations
        $targets = [];
        foreach ($categoryIds as $cid) {
            if ($includeCategoryOnly) {
                $targets[] = [$cid, null];
            }
            foreach ($locationIds as $locationId) {
                $targets[] = [$cid, $locationId];
            }
        }

        $created = 0;
        $reactivated = 0;
        $skipped = 0;

        foreach ($targets as [$categoryId, $locationId]) {
            $existing = Landing::forCombination($categoryId, $locationId)->first();
            if ($existing) {
                if (! $existing->isPublished() && $activateExisting) {
                    $existing->update(['status' => LandingStatus::Published, 'publish_at' => null]);
                    $reactivated++;
                } else {
                    $skipped++;
                }

                continue;
            }

            Landing::create([
                'category_id' => $categoryId,
                'location_id' => $locationId,
                'status' => LandingStatus::Published,
            ]);
            $created++;
        }

        return Response::json([
            'created' => $created,
            'reactivated' => $reactivated,
            'skipped' => $skipped,
            'total_targets' => count($targets),
        ]);
    }

    /**
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'category_ids' => $schema->array()
                ->items($schema->integer())
                ->description('Category ids to combine')
                ->required(),
            'location_ids' => $schema->array()
                ->items($schema->integer())
                ->description('Location ids to combine. Omit/empty to only create category-only landings (with include_category_only=true)'),
            'include_category_only' => $schema->boolean()
                ->description('Also create one landing per category with location_id=null'),
            'activate_existing' => $schema->boolean()
                ->description('Reactivate landings that exist but are inactive'),
        ];
    }
}
