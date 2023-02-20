<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'kasem Roomea',
            'email' => 'kasem711roomea@gmail.com',
            'password' => bcrypt('123456789'),
            'status' => 'مفعل',
            'roles_name' => 'Admin',
]);

$role = Role::create(['name' => 'Admin']);

$permissions = Permission::pluck('id','id')->all();

$role->syncPermissions($permissions);

$user->assignRole([$role->id]);

}
}
