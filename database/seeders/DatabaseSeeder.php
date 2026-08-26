<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'team.read', 'team.create', 'team.update', 'team.delete',
            'project.read', 'project.create', 'project.update', 'project.delete',
            'task.read', 'task.create', 'task.update', 'task.delete',
            'taskshow.read', 'taskshow.update',
            'tag.read', 'tag.create', 'tag.update', 'tag.delete',
            'teamsview.read', 'projectsview.read',
            'taskview.read',
        ];

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole->givePermissionTo(Permission::all());
        $managerRole->givePermissionTo([
            'team.read', 'project.read', 'project.create', 'project.update', 'project.delete',
            'task.read', 'task.create', 'task.update', 'task.delete',
            'taskshow.read',
            'tag.read', 'tag.create', 'tag.update', 'tag.delete',
            'teamsview.read', 'projectsview.read',
            'taskview.read',
        ]);
        $memberRole->givePermissionTo([
            'task.read', 'taskshow.read', 'taskshow.update',
            'taskview.read',
        ]);

        $tags = Tag::factory(rand(6, 10))->create();

        $existingTeams = Team::count();
        $teamsNeeded = max(0, 2 - $existingTeams);

        if ($teamsNeeded > 0) {
            Team::factory($teamsNeeded)->create();
        }

        $teams = Team::take(2)->get();

        foreach ($teams as $team) {
            $managerUser = User::factory()->create(['team_id' => $team->id]);
            $managerUser->assignRole('manager');

            $memberUsers = User::factory(3)->create(['team_id' => $team->id]);
            $memberUsers->each->assignRole('member');

            $teamUsers = $memberUsers->prepend($managerUser);

            $projects = Project::factory(rand(3, 5))->create(['team_id' => $team->id]);

            foreach ($projects as $project) {
                $tasks = Task::factory(rand(4, 8))->create([
                    'project_id' => $project->id,
                    'assignee_id' => $teamUsers->random()->id,
                ]);

                foreach ($tasks as $task) {
                    $task->tags()->attach(
                        $tags->random(rand(1, 3))->pluck('id')->toArray(),
                        [
                            'added_by' => $teamUsers->random()->id,
                            'added_at' => Carbon::now(),
                        ]
                    );

                    $watcherCount = min(rand(0, 3), $teamUsers->count());
                    if ($watcherCount > 0) {
                        $task->watchers()->attach(
                            $teamUsers->random($watcherCount)->pluck('id')->toArray()
                        );
                    }

                    Comment::factory(rand(0, 3))->create([
                        'task_id' => $task->id,
                        'user_id' => $teamUsers->random()->id,
                    ]);
                }
            }
        }

        $adminTeam = Team::firstOrCreate(['name' => 'Admin Team']);

        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('password'),
                'team_id' => $adminTeam->id,
            ]
        );
        $testUser->assignRole('admin');

        $testUser2 = User::firstOrCreate(
            ['email' => 'test2@example.com'],
            [
                'name' => 'Test Manager',
                'password' => bcrypt('password'),
                'team_id' => $adminTeam->id,
            ]
        );
        $testUser2->assignRole('manager');

        $testUser3 = User::firstOrCreate(
            ['email' => 'test3@example.com'],
            [
                'name' => 'Test Member',
                'password' => bcrypt('password'),
                'team_id' => $adminTeam->id,
            ]
        );
        $testUser3->assignRole('member');
    }
}
