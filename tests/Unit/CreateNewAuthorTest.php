<?php 
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use App\Actions\CreateNewAuthor;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewAuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_new_author()
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
    }

    /** @test */
    public function it_does_not_create_a_duplicate_author()
    {
        $author = [
            'id' => 'John',
            'created' => 12333223,
            'karma' => 12343,
            'about' => 'test paragraph',
            'submitted' => ['1234', '5678'],
        ];

        $action = new CreateNewAuthor();
        $action->create($author);

        $this->assertDatabaseCount('authors', 1);
    }
}