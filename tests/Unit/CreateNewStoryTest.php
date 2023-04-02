<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Story;
use App\Models\Author;
use App\Actions\CreateNewStory;
use App\Actions\CreateNewAuthor;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewStoryTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   public function can_create_story()
   {
        $input = [
            'id' => 'John',
            'created' => 12333223,
            'karma' => 12343,
            'about' => 'test paragraph',
            'submitted' => ['1234', '5678']
        ];

        $action = new CreateNewAuthor();
        $action->create($input);

        $this->assertCount(1, Author::all());

       $input = [
           'id' => '123',
           'title' => 'Test Title',
           'url' => 'https://example.com',
           'text' => null,
           'score' => 10,
           'by' => 'John',
           'time' => time(),
           'descendants' => null,
           'deleted' => false,
           'dead' => false,
           'category' => 'new'
       ];

       $action = new CreateNewStory;
       $result = $action->create($input);

       $this->assertTrue($result);
       $this->assertCount(1, Story::all());
   }

   /** @test */
   public function cannot_create_duplicate_story()
   {
       $input = [
           'id' => '123',
           'title' => 'Test Title',
           'url' => 'https://example.com',
           'text' => null,
           'score' => 10,
           'by' => 'John',
           'time' => time(),
           'descendants' => null,
           'deleted' => false,
           'dead' => false,
           'category' => 'new'
       ];

       // Create the story first
       $action = new CreateNewStory;
       $action->create($input);

       // Try to create the story again
       $result = $action->create($input);

       $this->assertFalse($result);
       $this->assertDatabaseCount('stories', 1);
       $this->assertEquals(1, DB::table('stories')->count()); // should still only have 1 row in the table
   }
}
