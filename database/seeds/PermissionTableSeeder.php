<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //remove currencies from client
        $exists = Permission::where('name', 'create-currencies')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'read-currencies')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'update-currencies')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'delete-currencies')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        //remove banks from client
        $exists = Permission::where('name', 'create-banks')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'read-banks')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'update-banks')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        $exists = Permission::where('name', 'delete-banks')->where('type', 'client')->first();
        if ($exists) {
            $exists->delete();
        }
        // Admin permissions
        $adminPermissions = collect([
            'clients',
            'client_users',
            'client_permissions',
            'admin_permissions',
            'admins',
            'currencies',
            'banks',
        ]);

        $adminPermissions->each(function ($item) {
            Permission::updateOrCreate(
                [
                    'name' => 'create-' . str_replace("_", "-", $item),
                ],
                [
                    'name' => 'create-' . str_replace("_", "-", $item),
                    'type' => 'admin',
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Create',
                    'description' => "The user can create " . str_replace("_", " ", $item),
                ]
            );

            Permission::updateOrCreate(
                [
                    'name' => 'read-' . str_replace("_", "-", $item),
                ],
                [
                    'name' => 'read-' . str_replace("_", "-", $item),
                    'type' => 'admin',
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Read',
                    'description' => "The user can read " . str_replace("_", " ", $item),
                ]
            );

            Permission::updateOrCreate(
                [
                    'name' => 'update-' . str_replace("_", "-", $item),

                ],
                [
                    'name' => 'update-' . str_replace("_", "-", $item),
                    'type' => 'admin',
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Update',
                    'description' => "The user can update " . str_replace("_", " ", $item),
                ]
            );

            Permission::updateOrCreate(
                [
                    'name' => 'delete-' . str_replace("_", "-", $item),
                ],
                [
                    'name' => 'delete-' . str_replace("_", "-", $item),
                    'type' => 'admin',
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Delete',
                    'description' => "The user can delete " . str_replace("_", " ", $item),
                ]
            );
        });

        // Client permissions
        $clientPermissions = collect([
            'material_categories',
            'product_categories',
            'products',
            'productions',
            'production_cost_categories',
            'production_costs',
            'branches',
            'accounts',
            'purchases',
            'costs',
            'receives',
            'payments',
            'expenses',
            'suppliers',
            'users',
            'roles',
            'units',
            'cost_types',
            'transaction_categories',
            'branch_users',
            'product_transfers',
            'branch_product_inventories',
            'product_transfer_receives',

        ]);

        $clientPermissions->each(function ($item) {
            Permission::updateOrCreate(
                [
                    'name' => 'create-' . str_replace("_", "-", $item),
                ],
                [
                    'name' => 'create-' . str_replace("_", "-", $item),
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Create',
                    'description' => "The user can create " . str_replace("_", " ", $item),
                ]
            );

            Permission::updateOrCreate(
                [
                    'name' => 'read-' . str_replace("_", "-", $item),
                ],
                [
                    'name' => 'read-' . str_replace("_", "-", $item),
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Read',
                    'description' => "The user can read " . str_replace("_", " ", $item),
                ]
            );

            Permission::updateOrCreate(
                [
                    'name' => 'update-' . str_replace("_", "-", $item),
                ],
                [
                    'name' => 'update-' . str_replace("_", "-", $item),
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Update',
                    'description' => "The user can update " . str_replace("_", " ", $item),
                ]
            );

            Permission::updateOrCreate(
                [
                    'name' => 'delete-' . str_replace("_", "-", $item),
                ],
                [
                    'name' => 'delete-' . str_replace("_", "-", $item),
                    'display_name' => Str::title(str_replace("_", " ", $item)) . ' Delete',
                    'description' => "The user can delete " . str_replace("_", " ", $item),
                ]
            );
        });
    }
}
