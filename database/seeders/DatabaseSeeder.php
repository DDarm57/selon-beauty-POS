<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Profile;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   /**
    * Seed the application's database.
    */
   public function run(): void
   {
      // \App\Models\User::factory(10)->create();

      // \App\Models\User::factory()->create([
      //     'name' => 'Test User',
      //     'email' => 'test@example.com',
      // ]);

      User::create([
         'name' => 'Admin',
         'email' => 'admin@gmail.com',
         'username' => 'admin',
         'password' => bcrypt('12345678'),
         'default_password' => 'selonbeauty',
         'role' => '1',
         'status' => 'active'
      ]);

      User::create([
         'name' => 'User',
         'email' => 'user@gmail.com',
         'username' => 'user',
         'password' => bcrypt('12345678'),
         'default_password' => 'selonbeauty',
         'role' => '2',
         'status' => 'active'
      ]);

      Category::create([
         'name' => 'Sabun'
      ]);

      Category::create([
         'name' => 'Pasta Gigi'
      ]);

      Category::create([
         'name' => 'Shampoo'
      ]);

      Product::create([
         'name' => 'Lifebuoy',
         'code' => 'LB001',
         'price' => 5000,
         'agent_price' => 4500,
         'discount' => 0,
         'stock' => 100,
         'image' => ''
      ])->categories()->attach(1);

      Product::create([
         'name' => 'Pepsodent',
         'code' => 'PD001',
         'price' => 10000,
         'agent_price' => 9000,
         'discount' => 0,
         'stock' => 50,
         'image' => ''
      ])->categories()->attach(2);

      Stock::create([
         'product_id' => 1,
         'stock' => 100
      ]);

      Stock::create([
         'product_id' => 2,
         'stock' => 50
      ]);

      Expense::create([
         'name' => 'Pembelian Sabun Mandi',
         'description' => 'Pembelian Sabun Mandi',
         'amount' => 10000,
         'date' => now()
      ]);

      Profile::create([
         'name' => 'Selon Beauty',
         'email' => 'selonbeauty@gmail.com',
         'phone' => '08123456789',
         'address' => 'Jl. Jend. Sudirman No. 123, Jakarta Selatan',
         'tiktok' => 'selonbeauty',
         'instagram' => 'selonbeauty',
         'image' => ''
      ]);
   }
}
