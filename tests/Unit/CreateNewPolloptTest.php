<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use App\Models\Pollopt;
use App\Actions\CreateNewPoll;
use App\Actions\CreateNewAuthor;
use App\Actions\CreateNewPollopt;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewPolloptTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_new_pollopt()
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
           'id' => 12223,
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

        $input = [
            'id' => 1233,
            'by' => 'John',
            'poll_id' => 12223,
            'score' => 10,
            'text' => 'Test text',
            'time' => 323,
            'deleted' => true,
            'dead' => false,
        ];

        $action = new CreateNewPollopt();
        $action->create($input, 12223);

        $this->assertCount(1, Pollopt::all());
    }

    /** @test */
    public function it_does_not_create_a_new_pollopt_if_id_already_exists()
    {
        $input = [
            'id' => 1233,
            'by' => 'John',
            'poll_id' => 12223,
            'score' => 10,
            'text' => 'Test text',
            'time' => 323,
            'deleted' => true,
            'dead' => false,
        ];

        $action = new CreateNewPollopt();
        $result = $action->create($input, 1233);

        $this->assertFalse($result);
        $this->assertDatabaseCount('pollopts', 1);
        $this->assertEquals(1, DB::table('pollopts')->count()); 
    }
}
