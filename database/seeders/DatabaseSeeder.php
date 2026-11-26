<?php
namespace Database\Seeders;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder { public function run(): void { User::updateOrCreate(['email' => 'ferrence.alagad@example.com'], ['name' => 'FERRENCE MIGUEL ALAGAD', 'password' => Hash::make('TaskToday123!')]); Task::insert([['title'=>'Review database design','status'=>'done','task_date'=>'2026-09-21','is_archived'=>false,'created_at'=>now(),'updated_at'=>now()],['title'=>'Prepare system layout','status'=>'pending','task_date'=>now()->toDateString(),'is_archived'=>false,'created_at'=>now(),'updated_at'=>now()],['title'=>'Submit project documentation','status'=>'pending','task_date'=>now()->addDay()->toDateString(),'is_archived'=>false,'created_at'=>now(),'updated_at'=>now()]]); } }
