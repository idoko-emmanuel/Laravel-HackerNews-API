<?php

namespace App\Jobs;

use App\Models\Story;
use App\Models\Author;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use App\Jobs\FetchHackernewsData;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class FetchHackernewsData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Story $story, 
        public Author $author, 
        public Comment $comment,) 
    {

    }

    /**
     * Execute the job.
     */
    public function handle(FetchHackernewsData $fetchData): void
    {
        //
    }
}
