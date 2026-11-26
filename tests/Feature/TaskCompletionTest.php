<?php
namespace Tests\Feature;
use App\Mail\TaskCompleted;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class TaskCompletionTest extends TestCase { use RefreshDatabase; public function test_completion_sends_once(): void { Mail::fake(); $user = User::factory()->create(); $task = Task::create(['title'=>'Demo','status'=>'pending','task_date'=>now(),'is_archived'=>false]); $this->actingAs($user)->put(route('tasks.update',$task), ['title'=>'Demo','status'=>'done','task_date'=>now()->toDateString()])->assertRedirect(); Mail::assertSent(TaskCompleted::class, 1); $this->actingAs($user)->put(route('tasks.update',$task), ['title'=>'Demo updated','status'=>'done','task_date'=>now()->toDateString()]); Mail::assertSent(TaskCompleted::class, 1); } }
