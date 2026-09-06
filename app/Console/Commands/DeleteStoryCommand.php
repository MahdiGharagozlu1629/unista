<?php

namespace App\Console\Commands;

use App\Models\Story;
use Illuminate\Console\Command;

class DeleteStoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-story-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Story After 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Story::query()
            ->where('created_at', '>=', now()->subDay())
            ->delete();
    }
}
