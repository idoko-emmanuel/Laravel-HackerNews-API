<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use App\Models\HackerJob;
use App\Actions\CreateNewJob;
use App\Actions\CreateNewAuthor;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_new_job()
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
            'by' => 'John',
            'score' => 10,
            'text' => 'test job description',
            'time' => now()->timestamp,
            'title' => 'Test Job',
            'url' => 'https://example.com',
            'deleted' => false,
            'dead' => false,
        ];

        $action = new CreateNewJob;
        $result = $action->create($input);

        $this->assertTrue($result);

        $this->assertCount(1, HackerJob::all());
    }

    /** @test */
    public function it_does_not_create_duplicate_job()
    {
        $input = [
            'id' => '123',
            'by' => 'testuser',
            'score' => 10,
            'text' => 'test job description',
            'time' => now()->timestamp,
            'title' => 'Test Job',
            'url' => 'https://example.com',
            'deleted' => false,
            'dead' => false,
        ];

        // Create a job with the same ID

        $action = new CreateNewJob;
        $result = $action->create($input);

        $this->assertFalse($result);
        $this->assertDatabaseCount('hacker_jobs', 1);
        $this->assertEquals(1, DB::table('hacker_jobs')->count());
    }

    /** @test */
    public function it_throws_validation_exception_for_invalid_input()
    {
        $input = [
            'id' => '123',
            'by' => 'testuser',
            'score' => 'not_an_integer',
            'time' => 'not_an_integer',
            'url' => 'not_a_url',
        ];

        $action = new CreateNewJob;

        $this->expectException(ValidationException::class);
        $action->create($input);
    }
}
