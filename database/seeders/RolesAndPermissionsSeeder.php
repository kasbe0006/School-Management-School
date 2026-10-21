<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'students.view', 'students.create', 'students.edit', 'students.delete',
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'classes.view', 'classes.create', 'classes.edit', 'classes.delete',
            'sections.view', 'sections.create', 'sections.edit', 'sections.delete',
            'subjects.view', 'subjects.create', 'subjects.edit', 'subjects.delete',
            'exams.view', 'exams.create', 'exams.edit', 'exams.delete',
            'marks.view', 'marks.create', 'marks.edit', 'marks.delete',
            'payments.view', 'payments.create', 'payments.edit', 'payments.delete',
            'timetables.view', 'timetables.create', 'timetables.edit', 'timetables.delete',
            'dorms.view', 'dorms.create', 'dorms.edit', 'dorms.delete',
            'books.view', 'books.create', 'books.edit', 'books.delete',
            'pins.view', 'pins.create', 'pins.delete',
            'grades.view', 'grades.create', 'grades.edit', 'grades.delete',
            'settings.view', 'settings.edit',
            'promotions.view', 'promotions.manage',
            'reports.view',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'students.view', 'students.create', 'students.edit', 'students.delete',
            'users.view', 'users.create', 'users.edit',
            'classes.view', 'classes.create', 'classes.edit',
            'sections.view', 'sections.create', 'sections.edit',
            'subjects.view', 'subjects.create', 'subjects.edit',
            'exams.view', 'exams.create', 'exams.edit',
            'marks.view', 'marks.create', 'marks.edit',
            'payments.view', 'payments.create', 'payments.edit',
            'timetables.view', 'timetables.create', 'timetables.edit',
            'dorms.view', 'dorms.create', 'dorms.edit',
            'books.view', 'books.create', 'books.edit',
            'pins.view', 'pins.create',
            'grades.view', 'grades.create', 'grades.edit',
            'settings.view',
            'promotions.view', 'promotions.manage',
            'reports.view',
        ]);

        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'students.view',
            'classes.view',
            'sections.view',
            'subjects.view',
            'exams.view',
            'marks.view', 'marks.create', 'marks.edit',
            'timetables.view',
            'books.view',
        ]);

        $accountant = Role::firstOrCreate(['name' => 'accountant']);
        $accountant->givePermissionTo([
            'students.view',
            'payments.view', 'payments.create', 'payments.edit',
            'pins.view', 'pins.create',
            'reports.view',
        ]);

        $librarian = Role::firstOrCreate(['name' => 'librarian']);
        $librarian->givePermissionTo([
            'books.view', 'books.create', 'books.edit', 'books.delete',
            'students.view',
        ]);

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo([
            'marks.view',
            'payments.view',
            'timetables.view',
            'books.view',
        ]);

        $parent = Role::firstOrCreate(['name' => 'parent']);
        $parent->givePermissionTo([
            'students.view',
            'marks.view',
            'payments.view',
            'timetables.view',
        ]);
    }
}

</ARG>