<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Landing;
use Illuminate\Console\Command;

class PublishScheduledLandingsCommand extends Command
{
    protected $signature = 'landings:publish-scheduled';

    protected $description = 'Publish scheduled landings whose publish_at date has been reached';

    public function handle(): int
    {
        $due = Landing::dueForPublishing()->get();

        $due->each(fn (Landing $landing): mixed => $landing->publish());

        $this->info("Published {$due->count()} scheduled landing(s).");

        return self::SUCCESS;
    }
}
