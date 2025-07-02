<?php

namespace Tests\Feature\Exam;

use Tests\TestCase;
use App\Models\User;
use App\Models\Exam\ExamGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class ExamGroupAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $adminRoute = '/exam-groups';

    // Svaki test ima potrebne role, pa nema više RoleDoesNotExist!
    public function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'student']);
    }

    /** @test */
    public function super_admin_can_see_exam_groups_index()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        ExamGroup::factory()->count(2)->create();

        $response = $this->actingAs($admin)->get($this->adminRoute);
        $response->assertStatus(200);
        $response->assertSee('Grupe');
    }

    /** @test */
    public function student_cannot_access_admin_exam_groups_index()
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $response = $this->actingAs($student)->get($this->adminRoute);
        // Ovde možeš proveriti i za 403 i za 302, u zavisnosti šta middleware vraća
        $response->assertStatus(in_array($response->getStatusCode(), [403, 302]) ? $response->getStatusCode() : 403);
    }

    /** @test */
    public function super_admin_can_create_exam_group()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');

        $data = [
            'name' => 'Test grupa',
            'start_date' => now()->toDateString(),
            'exam_date' => now()->addDays(10)->toDateString(),
        ];

        $response = $this->actingAs($admin)->post($this->adminRoute, $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('exam_groups', ['name' => 'Test grupa']);
    }

    /** @test */
    public function student_cannot_create_exam_group()
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $data = [
            'name' => 'Fake grupa',
            'start_date' => now()->toDateString(),
        ];

        $response = $this->actingAs($student)->post($this->adminRoute, $data);

        $response->assertStatus(in_array($response->getStatusCode(), [403, 302]) ? $response->getStatusCode() : 403);
        $this->assertDatabaseMissing('exam_groups', ['name' => 'Fake grupa']);
    }

    /** @test */
    public function super_admin_can_edit_and_update_exam_group()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $group = ExamGroup::factory()->create();

        $response = $this->actingAs($admin)->put($this->adminRoute.'/'.$group->id, [
            'name' => 'Novi naziv',
            'start_date' => now()->toDateString(),
            'exam_date' => now()->addDays(1)->toDateString(),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('exam_groups', ['id' => $group->id, 'name' => 'Novi naziv']);
    }

    /** @test */
    public function student_cannot_update_exam_group()
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $group = ExamGroup::factory()->create();

        $response = $this->actingAs($student)->put($this->adminRoute.'/'.$group->id, [
            'name' => 'Novi naziv studenta',
            'start_date' => now()->toDateString(),
        ]);
        $response->assertStatus(in_array($response->getStatusCode(), [403, 302]) ? $response->getStatusCode() : 403);
        $this->assertDatabaseMissing('exam_groups', ['name' => 'Novi naziv studenta']);
    }

    /** @test */
    public function super_admin_can_delete_exam_group()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $group = ExamGroup::factory()->create();

        $response = $this->actingAs($admin)->delete($this->adminRoute.'/'.$group->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('exam_groups', ['id' => $group->id]);
    }

    /** @test */
    public function student_cannot_delete_exam_group()
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $group = ExamGroup::factory()->create();

        $response = $this->actingAs($student)->delete($this->adminRoute.'/'.$group->id);
        $response->assertStatus(in_array($response->getStatusCode(), [403, 302]) ? $response->getStatusCode() : 403);
        $this->assertDatabaseHas('exam_groups', ['id' => $group->id]);
    }
}
