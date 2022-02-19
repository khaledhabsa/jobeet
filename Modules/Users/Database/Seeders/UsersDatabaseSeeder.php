<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('company')->insert([
            'name'          => 'Laravel',
            'description'   => 'info@laravel.com',
            'status'        => 'pending',
        ]);

        DB::table('users')->insert([
            'name'       => 'admin',
            'email'      => 'admin@mail.com',
            'company_id' => '1',
            'password'   => Hash::make('password'),
            'user_type'  => 'manager'
        ]);

        DB::table('users')->insert([
            'name'      => 'company name',
            'email'     => 'company@mail.com',
            'company_id' => '1',
            'password'  => Hash::make('password'),
            'user_type' => 'regular'
        ]);

        DB::table('roles')->insert(['name'  => 'Super admin', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('roles')->insert(['name'  => 'Super admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert([
            ['name' => 'roles.show', 'guard_name' =>'api'],
            ['name' => 'roles.create', 'guard_name' =>'api'],
            ['name' => 'roles.edit', 'guard_name' =>'api'],
            ['name' => 'roles.delete', 'guard_name' =>'api'],
            ['name' => 'moderator.show', 'guard_name' =>'api'],
            ['name' => 'moderator.create', 'guard_name' =>'api'],
            ['name' => 'moderator.edit', 'guard_name' =>'api'],
            ['name' => 'moderator.delete', 'guard_name' =>'api'],
            ['name' => 'roles.show', 'guard_name' =>'web'],
            ['name' => 'roles.create', 'guard_name' =>'web'],
            ['name' => 'roles.edit', 'guard_name' =>'web'],
            ['name' => 'roles.delete', 'guard_name' =>'web'],
            ['name' => 'moderator.show', 'guard_name' =>'web'],
            ['name' => 'moderator.create', 'guard_name' =>'web'],
            ['name' => 'moderator.edit', 'guard_name' =>'web'],
            ['name' => 'moderator.delete', 'guard_name' =>'web'],
            ['name' => 'jobs.show', 'guard_name' =>'api'],
            ['name' => 'jobs.create', 'guard_name' =>'api'],
            ['name' => 'jobs.edit', 'guard_name' =>'api'],
            ['name' => 'jobs.delete', 'guard_name' =>'api'],
            ['name' => 'jobs.show', 'guard_name' =>'web'],
            ['name' => 'jobs.create', 'guard_name' =>'web'],
            ['name' => 'jobs.edit', 'guard_name' =>'web'],
            ['name' => 'jobs.delete', 'guard_name' =>'web'],
        ]);

        DB::table('model_has_roles')->insert([
            'role_id'       => 2,
            'model_type'    => 'Modules\Users\Entities\User',
            'model_id'      => 1
        ]);

        DB::table('model_has_roles')->insert([
            'role_id'       => 1,
            'model_type'    => 'Modules\Users\Entities\User',
            'model_id'      => 2
        ]);

        DB::table('role_has_permissions')->insert([
            ['role_id' => 1, 'permission_id' => 1],['role_id' => 1, 'permission_id' => 2],
            ['role_id' => 1, 'permission_id' => 3],['role_id' => 1, 'permission_id' => 4],
            ['role_id' => 1, 'permission_id' => 5],['role_id' => 1, 'permission_id' => 6],
            ['role_id' => 1, 'permission_id' => 7],['role_id' => 1, 'permission_id' => 8],
            ['role_id' => 1, 'permission_id' => 9],['role_id' => 1, 'permission_id' => 10],
            ['role_id' => 1, 'permission_id' => 11],['role_id' => 1, 'permission_id' => 12],
            ['role_id' => 2, 'permission_id' => 13],['role_id' => 2, 'permission_id' => 14],
            ['role_id' => 2, 'permission_id' => 15],['role_id' => 2, 'permission_id' => 16],
            ['role_id' => 2, 'permission_id' => 17],['role_id' => 2, 'permission_id' => 18],
            ['role_id' => 2, 'permission_id' => 19],['role_id' => 2, 'permission_id' => 20],
            ['role_id' => 2, 'permission_id' => 21],['role_id' => 2, 'permission_id' => 22],
            ['role_id' => 2, 'permission_id' => 23],['role_id' => 2, 'permission_id' => 24],
            ['role_id' => 1, 'permission_id' => 25],['role_id' => 1, 'permission_id' => 26],
            ['role_id' => 1, 'permission_id' => 27],['role_id' => 1, 'permission_id' => 28],
            ['role_id' => 2, 'permission_id' => 29],['role_id' => 2, 'permission_id' => 30],
            ['role_id' => 2, 'permission_id' => 31],['role_id' => 2, 'permission_id' => 32],
        ]);
    }
}
