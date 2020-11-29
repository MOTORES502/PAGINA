<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Sistema\Blog;
use Faker\Generator as Faker;
use App\Models\Sistema\ViewPage;
use App\Models\Sistema\TestDrive;
use App\Models\Sistema\Transport;
use App\Models\Sistema\Comparation;
use App\Models\Sistema\TransportView;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Blog::class, function (Faker $faker) {
    $img = 'data:image/png;base64,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';
    return [
        'image' => $img,
        'name' => $faker->unique()->company,
        'description' => $faker->text(rand(500, 2500)),
        'users_id' => User::all()->random()->id
    ];
});

$factory->define(TransportView::class, function (Faker $faker) {
    return [
        'type_view' => $faker->randomElement(['PAGINA INICIO', 'RECOMENDACION', 'BUSCADOR']),
        'visitor' => $faker->ipv4,
        'transports_id' => Transport::all()->random()->id,
        'anio' => $faker->year(date('Y'))
    ];
});

$factory->define(ViewPage::class, function (Faker $faker) {
    return [
        'anio' => $faker->year(date('Y')),
        'visitor' => $faker->ipv4
    ];
});

$factory->define(Comparation::class, function (Faker $faker) {
    return [
        'one_id' => Transport::all()->random()->id,
        'two_id' => Transport::all()->random()->id,
        'visitor' => $faker->ipv4
    ];
});

$factory->define(TestDrive::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->freeEmail,
        'name' => $faker->randomElement([$faker->name('male'), $faker->name('female')]),
        'number' => $faker->e164PhoneNumber,
        'date_time' => $faker->dateTime(Carbon::now(), 'America/Guatemala'),
        'observation' => $observacion = $faker->randomElement([$faker->text(rand(100, 500)), null]),
        'users_id' => $observacion ? User::all()->random()->id : 0,
        'transports_id' => Transport::all()->random()->id
    ];
});
