<?php

use App\Setting;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->call('ClearSeeder');
	}

}

class ClearSeeder extends Seeder {
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('post_tag')->truncate();
        DB::table('posts')->truncate();
        DB::table('tags')->truncate();
        DB::table('questions')->truncate();
        DB::table('settings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Setting::create([
            'name' => 'meta_title',
            'value' => env('META_TITLE'),
        ]);

        Setting::create([
            'name' => 'meta_desc',
            'value' => env('META_DESC'),
        ]);

        Setting::create([
            'name' => 'meta_keywords',
            'value' => env('META_KEYWORDS'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'tieumaster@yahoo.com',
            'password' => Hash::make('232323')
        ]);

    }
}
