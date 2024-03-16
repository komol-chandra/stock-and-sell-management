<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Create Admin
        |--------------------------------------------------------------------------
         */
        User::create([
            'name'       => 'Admin',
            'email'      => 'admin@gmail.com',
            'role_id'    => 1,
            'is_active'  => 1,
            'password'   => Hash::make('12345678'),
            'created_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Branch
        |--------------------------------------------------------------------------
         */

        $branches = [
            [
                'name'       => 'Ware House',
                'phone'      => '01874303068',
                'address'    => 'House 2, Road 4, H Block, Mirpur -1 , Dhaka',
                'email'      => 'warehouse@gmail.com',
                'is_active'  => 1,
                'created_at' => now(),
            ],
            [
                'name'       => 'Online Store',
                'phone'      => '01874303068',
                'address'    => 'House 2, Road 4, H Block, Mirpur -1 , Dhaka',
                'email'      => 'onlinestore@gmail.com',
                'is_active'  => 1,
                'created_at' => now(),
            ],
            [
                'name'       => 'Off Line Store',
                'phone'      => '01874303068',
                'address'    => 'House 2, Road 4, H Block, Mirpur -1 , Dhaka',
                'email'      => 'offlinestore@gmail.com',
                'is_active'  => 1,
                'created_at' => now(),
            ],
        ];

        Branch::insert($branches);

        /*
        |--------------------------------------------------------------------------
        | Create Branch wish user
        |--------------------------------------------------------------------------
         */

        $branchUsers = [
            [
                'name'       => 'warehouse',
                'email'      => 'warehouse@gmail.com',
                'role_id'    => '2',
                'branch_id'  => '1',
                'is_active'  => '1',
                'password'   => Hash::make('12345678'),
                'created_at' => now(),
            ],
            [
                'name'       => 'onlinestore',
                'email'      => 'onlinestore@gmail.com',
                'role_id'    => '2',
                'branch_id'  => '2',
                'is_active'  => '1',
                'password'   => Hash::make('12345678'),
                'created_at' => now(),
            ],
            [
                'name'       => 'offlinestore',
                'email'      => 'offlinestore@gmail.com',
                'role_id'    => '2',
                'branch_id'  => '3',
                'is_active'  => '1',
                'password'   => Hash::make('12345678'),
                'created_at' => now(),
            ],
        ];

        User::insert($branchUsers);

        /*
        |--------------------------------------------------------------------------
        | Create Category
        |--------------------------------------------------------------------------
         */
        $categories = [
            ['name' => 'Meat & fish', 'slug' => 'meat-and-fish', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Dairy', 'slug' => 'dairy', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Vegetables and fruit', 'slug' => 'vegetables-and-fruit', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Snacks', 'slug' => 'snacks', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Bread & bread spreads', 'slug' => 'bread-and-bread-spreads', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'dry-goods', 'slug' => 'dry-goods', 'is_active' => 1, 'created_at' => now()],
        ];

        Category::insert($categories);

        /*
        |--------------------------------------------------------------------------
        | Create Brand
        |--------------------------------------------------------------------------
         */
        $brands = [
            ['name' => 'Transcom Beverages Ltd. (TBL)', 'slug' => 'Transcom-Beverages-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Square Food & Beverage Ltd. (SFBL)', 'slug' => 'Square-Food-and-Beverage-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => ' Akij Food and Beverage Ltd. (AFBL)', 'slug' => 'Akij-Food-and-Beverage-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Partex Beverage Ltd.', 'slug' => 'Partex-Beverage-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'PRAN Foods Ltd.', 'slug' => 'PRAN-Foods-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'ACI Foods Ltd.', 'slug' => 'ACI-Foods-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'IFAD Multi Products Ltd.', 'slug' => 'IFAD-Multi-Products-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Fu-Wang Foods Ltd.', 'slug' => 'Fu-Wang-Foods-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Ispahani Foods Ltd.', 'slug' => 'Ispahani-Foods-Ltd', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Bombay Sweets & Co. Ltd.', 'slug' => 'Bombay-Sweets-and-Co-Ltd', 'is_active' => 1, 'created_at' => now()],
        ];

        Brand::insert($brands);
        /*
        |--------------------------------------------------------------------------
        | Create Unit
        |--------------------------------------------------------------------------
         */
        $units = [
            ['name' => 'Weight KG', 'slug' => 'weight-kg', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Weight Gram', 'slug' => 'weight-gram', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Volume Liter', 'slug' => 'volume-liter', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Volume Milliliters', 'slug' => 'volume-milliliters', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Piece', 'slug' => 'piece', 'is_active' => 1, 'created_at' => now()],
            ['name' => 'Pack', 'slug' => 'pack', 'is_active' => 1, 'created_at' => now()],
        ];

        Unit::insert($units);

        /*
        |--------------------------------------------------------------------------
        | Create Supplier
        |--------------------------------------------------------------------------
         */
        $suppliers = [
            [
                'name'       => 'Mr Akash Rohman',
                'phone'      => '01874303069',
                'address'    => 'House 09, Road 40, M Block, Mirpur -4 , Dhaka',
                'email'      => 'akash@gmail.com',
                'is_active'  => 1,
                'created_at' => now(),
            ],
            [
                'name'       => 'Mr June',
                'phone'      => '01874303078',
                'address'    => 'House 09, Road 40, M Block, Mirpur -4 , Dhaka',
                'email'      => 'june@gmail.com',
                'is_active'  => 1,
                'created_at' => now(),
            ],
            [
                'name'       => 'Mr Korim Mama',
                'phone'      => '01874303168',
                'address'    => 'House 09, Road 40, M Block, Mirpur -4 , Dhaka',
                'email'      => 'korim@gmail.com',
                'is_active'  => 1,
                'created_at' => now(),
            ],
            [
                'name'       => 'Mr HaziMan',
                'phone'      => '01874303168',
                'address'    => 'House 19, Road 40, M Block, Mirpur -4 , Dhaka',
                'email'      => 'haziman@gmail.com',
                'is_active'  => 1,
                'created_at' => now(),
            ],
        ];

        Supplier::insert($suppliers);

    }
}
