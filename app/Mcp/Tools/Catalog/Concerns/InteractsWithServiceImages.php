<?php

declare(strict_types=1);

namespace App\Mcp\Tools\Catalog\Concerns;

use App\Models\Service;
use Throwable;

trait InteractsWithServiceImages
{
    /**
     * Sync the service's additional categories, never duplicating its primary
     * `category_id`. Pass null to leave the current set untouched.
     *
     * @param  array<int, int>|null  $categoryIds
     */
    protected function syncAdditionalCategories(Service $service, ?array $categoryIds): void
    {
        if ($categoryIds === null) {
            return;
        }

        $service->additionalCategories()->sync(array_values(array_filter(
            array_unique(array_map('intval', $categoryIds)),
            fn (int $id): bool => $id !== $service->category_id,
        )));
    }

    /**
     * Download and attach a list of image URLs to the service's gallery.
     *
     * @param  list<string>  $urls
     * @return array{attached: int, errors: list<string>}
     */
    protected function attachImages(Service $service, array $urls): array
    {
        $attached = 0;
        $errors = [];

        foreach ($urls as $url) {
            try {
                $service->addMediaFromUrl($url)->toMediaCollection('gallery');
                $attached++;
            } catch (Throwable $e) {
                $errors[] = "{$url}: {$e->getMessage()}";
            }
        }

        return ['attached' => $attached, 'errors' => $errors];
    }
}
