<?php

namespace Tests\Feature\Actions;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\Story;
use App\Models\Author;
use App\Models\Comment;
use App\Actions\CreateNewPoll;
use App\Actions\CreateNewStory;
use App\Actions\CreateNewAuthor;
use App\Actions\CreateNewComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateNewCommentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_new_comment_for_a_story()
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

        $input = [
            'id' => 32342,
            'text' => 'example text',
            'by' => 'John',
            'points' => 9333,
            'parent' => 123,
            'source' => 'story',
        ];

        $action = new CreateNewComment;
        $result = $action->createnew($input, 123);

        $this->assertTrue($result);
        $this->assertCount(1, Comment::all());
        
    }

    /** @test */
    public function it_creates_a_new_comment_for_a_poll()
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
           'id' => 1423,
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
            'id' => 332342,
            'text' => 'example text',
            'by' => 'John',
            'points' => 9333,
            'parent' => 1423,
            'source' => 'poll',
        ];

        $action = new CreateNewComment;
        $action->createnew($input, 1423);

        $this->assertTrue($result);
        $this->assertCount(2, Comment::all());
    }

    /** @test */
    public function it_creates_a_new_comment_for_a_comment()
    {

        $input = [
            'id' =>2332342,
            'text' => 'example text',
            'by' => 'John',
            'points' => 9333,
            'parent' => 332342,
            'source' => 'comment',
        ];

        $action = new CreateNewComment;
        $result = $action->createnew($input, 332342);

        $this->assertTrue($result);
        $this->assertCount(2, Comment::all());
    }

    /** @test */
    public function it_does_not_create_a_comment_if_it_already_exists()
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

        $input = [
            'id' => 32342,
            'text' => 'example text',
            'by' => 'John',
            'points' => 9333,
            'parent' => 123,
            'source' => 'story',
        ];

        $action = new CreateNewComment;
        $action->createnew($input, 123);

        // Try to create the story again
        $result =  $action->createnew($input, 123);

        $this->assertFalse($result);
        $this->assertDatabaseCount('comments', 2);
        $this->assertEquals(2, DB::table('comments')->count());
    }

}