<?php

namespace Modules\Coupon\database\seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Coupon\app\Models\Coupon;

class CouponDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            $coupon = new Coupon();
            $coupon->coupon_code = strtoupper($faker->regexify('[A-Z0-9]{' . rand(5, 10) . '}'));

            $coupon->discount_type = $faker->randomElement(['percentage', 'amount']);

            $startDate = $faker->dateTimeBetween('now', '+6 months');
            $expiredDate = $faker->dateTimeBetween($startDate, '+1 year');

            $coupon->start_date = $startDate->format('Y-m-d');
            $coupon->expired_date = $expiredDate->format('Y-m-d');

            if ($coupon->discount_type === 'percentage') {
                $coupon->discount = $faker->numberBetween(1, 50);
            } else {
                $coupon->discount = $faker->numberBetween(1, 200);
            }
            $coupon->min_price = $faker->numberBetween(100, 2000);

            $coupon->save();
        }
    }
}