<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Http\Middleware\OnlyAjax;
use Gamify\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Generate sample data for a form request.
     *
     * @param array $overrides
     *
     * @return array
     */
    private function generateRequestInputData(array $overrides = []): array
    {
        $question = factory(Question::class)->make();

        return array_merge([
            'name' => $question->name,
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,
            'choice_text' => ['correct', 'incorrect'],
            'choice_score' => [5, -5],
        ], $overrides);
    }

    /**
     * Create a Question acting as Admin user to honor Blameable Trait.
     *
     * @param array $overrides
     *
     * @return \Gamify\Question
     */
    private function createQuestionAsAdmin(array $overrides = []): Question
    {
        $this->actingAsAdmin();

        return factory(Question::class)->create($overrides);
    }

    /** @test */
    public function access_is_restricted_to_admins()
    {
        $question = $this->createQuestionAsAdmin();
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.questions.index')],
            ['protocol' => 'GET', 'route' => route('admin.questions.create')],
            ['protocol' => 'POST', 'route' => route('admin.questions.store')],
            ['protocol' => 'GET', 'route' => route('admin.questions.show', $question)],
            ['protocol' => 'GET', 'route' => route('admin.questions.edit', $question)],
            ['protocol' => 'PUT', 'route' => route('admin.questions.update', $question)],
            ['protocol' => 'GET', 'route' => route('admin.questions.delete', $question)],
            ['protocol' => 'DELETE', 'route' => route('admin.questions.destroy', $question)],
        ];

        foreach ($test_data as $test) {
            $this->actingAsUser()
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }

        // Ajax routes needs to disable middleware
        $this->actingAsUser()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.questions.data'))
            ->assertForbidden();
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.questions.index'))
            ->assertOK()
            ->assertViewIs('admin.question.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.questions.create'))
            ->assertOk()
            ->assertViewIs('admin.question.create')
            ->assertViewHasAll(['availableTags']);
    }

    /** @test */
    public function store_creates_an_object()
    {
        $input_data = $this->generateRequestInputData();

        $this->actingAsAdmin()
            ->post(route('admin.questions.store'), $input_data)
            ->assertRedirect(route('admin.questions.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function store_returns_errors_on_invalid_data()
    {
        $invalid_input_data = $this->generateRequestInputData([
            'name' => '',
        ]);

        $this->actingAsAdmin()
            ->post(route('admin.questions.store'), $invalid_input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function show_returns_proper_content()
    {
        $question = $this->createQuestionAsAdmin();

        $this->actingAsAdmin()
            ->get(route('admin.questions.show', $question))
            ->assertOk()
            ->assertViewIs('admin.question.show')
            ->assertSee($question->name);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        $question = $this->createQuestionAsAdmin();

        $this->actingAsAdmin()
            ->get(route('admin.questions.edit', $question))
            ->assertOk()
            ->assertViewIs('admin.question.edit')
            ->assertSee($question->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        $question = $this->createQuestionAsAdmin([
            'name' => 'Question gold',
        ]);
        $input_data = $this->generateRequestInputData([
            'name' => 'Question silver',
        ]);

        $this->actingAsAdmin()
            ->put(route('admin.questions.update', $question), $input_data)
            ->assertRedirect(route('admin.questions.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        $question = $this->createQuestionAsAdmin([
            'name' => 'Question gold',
        ]);
        $input_data = $this->generateRequestInputData([
            'name' => '',
        ]);

        $this->actingAsAdmin()
            ->put(route('admin.questions.update', $question), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function delete_returns_proper_content()
    {
        $question = $this->createQuestionAsAdmin();

        $this->actingAsAdmin()
            ->get(route('admin.questions.delete', $question))
            ->assertOk()
            ->assertViewIs('admin.question.delete')
            ->assertSee($question->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        $question = $this->createQuestionAsAdmin();

        $this->actingAsAdmin()
            ->delete(route('admin.questions.destroy', $question))
            ->assertRedirect(route('admin.questions.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function data_returns_proper_content()
    {
        $this->actingAsAdmin();
        factory(Question::class, 3)->create();

        $this->actingAsAdmin()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.questions.data'))
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function data_fails_for_non_ajax_calls()
    {
        $this->actingAsAdmin();
        factory(Question::class, 3)->create();

        $this->actingAsAdmin()
            ->get(route('admin.questions.data'))
            ->assertForbidden();
    }
}
