<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\Author;
use App\Actions\CreateNewPoll;
use App\Actions\CreateNewAuthor;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewPollTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_new_poll()
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
           'id' => 123,
           'by' => 'John',
           'descendants' => 34,
           'score' => 10,
           'title' => 'Test Title',
           'text' => 'sample text',
           'time' => 43433,
           'deleted' => false,
           'dead' => false,
       ];

        $action = new CreateNewPoll;
        $result = $action->create($input);

        $this->assertTrue($result);
        $this->assertCount(1, Poll::all());
    }

    /** @test */
    public function it_does_not_create_a_poll_if_id_already_exists()
    {
        $input = [
            'id' => 123,
            'by' => 'John',
            'descendants' => 34,
            'score' => 10,
            'title' => 'Test Title',
            'text' => 'sample text',
            'time' => 43433,
            'deleted' => false,
            'dead' => false,
        ];
 

         // Create the poll first
         $action = new CreateNewPoll;
         $result = $action->create($input);

       // Try to create the poll again
       $result = $action->create($input);

       $this->assertFalse($result);
       $this->assertDatabaseCount('polls', 1);
       $this->assertEquals(1, DB::table('polls')->count()); 
    }
}
