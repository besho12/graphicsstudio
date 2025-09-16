<?php

namespace Modules\Order\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Order\app\Models\ShippingMethod;
use Modules\Order\app\Models\ShippingMethodTranslation;

class ShippingMethodSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $methods = [
            ['title' => 'Standard', 'fee' => 0, 'is_default' => 1],
            ['title' => 'Express', 'fee' => 50],
        ];

        foreach ($methods as $value) {
            $method = New ShippingMethod();
            $method->fee = $value['fee'];
            if (isset($value['is_default'])) {
                $method->is_default = $value['is_default'];
            }

            if ($method->save()) {
                foreach (allLanguages() as $language) {
                    $dataTranslation = new ShippingMethodTranslation();
                    $dataTranslation->lang_code = $language->code;
                    $dataTranslation->shipping_method_id = $method->id;
                    $dataTranslation->title = $value['title'];
                    $dataTranslation->save();
                }
            }
        }
    }
}
