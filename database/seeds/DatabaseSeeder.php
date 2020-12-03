<?php

use App\Models\Sistema\Blog;
use Illuminate\Database\Seeder;
use App\Models\Sistema\ViewPage;
use App\Models\Sistema\TestDrive;
use App\Models\Sistema\Comparation;
use App\Models\Sistema\TransportView;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //factory(Blog::class, 200)->create();
        //factory(TransportView::class, 1000)->create();
        //factory(ViewPage::class, 2500)->create();
        factory(Comparation::class, 100)->create();
        //factory(TestDrive::class, 100)->create();
    }
}
