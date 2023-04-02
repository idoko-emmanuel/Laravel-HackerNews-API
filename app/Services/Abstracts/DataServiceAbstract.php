<?php 
namespace App\Services\Abstracts;

abstract class DataServiceAbstract
{
    private $url, $successfulSpool;

    abstract protected function CreateComment(int $post_id, string $source) : bool;

    abstract protected function CreatePollopt(int $post_id) : bool;

    abstract protected function getItemDetails(int $itemId) : mixed;

    abstract protected function newComment(int $comment_id, int $post_id, string $source) : bool;

    abstract protected function story($itemDetails, $category) : mixed;

    abstract protected function poll($itemDetails) : mixed;

    abstract protected function job($itemDetails) : mixed;

    abstract public function getItemType(int $itemId):string;

    abstract public function CreateAuthor(string $authorid) : bool;

    abstract public function CreateStory(int $itemId, string $category) : bool;

    abstract public function spoolFromMaxItem() : mixed;

    abstract public function spoolFromTopStories() : mixed;

    abstract public function spoolFromNewStories() : mixed;

    abstract public function spoolFromShowStories() : mixed;

    abstract public function spoolFromAskStories() : mixed;

    abstract public function spoolFromJobs() : mixed;

    abstract public function spoolFromBestStories(): mixed;
}