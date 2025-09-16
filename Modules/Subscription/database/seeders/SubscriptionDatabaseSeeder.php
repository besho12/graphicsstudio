<?php

namespace Modules\Subscription\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Subscription\app\Models\SubscriptionPlan;
use Modules\Subscription\app\Models\SubscriptionPlanTranslation;

class SubscriptionDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $dummyData = [
            [
                'plan_price'      => 180,
                'expiration_date' => 'monthly', //yearly lifetime monthly
                'translations' => [
                    [
                        'lang_code'         => 'en',
                        'plan_name'         => 'Startup',
                        'short_description' => 'We care about their success. For us real relationships fuel real',
                        'description'       => '<ul>
                                                <li> Web & Mobile</li>
                                                <li> Free Custom Domain</li>
                                                <li> Best Hosting Ever</li>
                                                <li> Outstanding Support</li>
                                                <li> Web Design</li>
                                                </ul>',
                        'button_text'       => 'Choose This Plan',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'plan_name'         => 'चालू होना',
                        'short_description' => 'हम उनकी सफलता की परवाह करते हैं। हमारे लिए सच्चे रिश्ते ही असली प्रेरणा देते हैं',
                        'description'       => '<ul>
                                                <li> वेब और मोबाइल</li>
                                                <li> निःशुल्क कस्टम डोमेन</li>
                                                <li> अब तक की सर्वश्रेष्ठ होस्टिंग</li>
                                                <li> उत्कृष्ट सहायता</li>
                                                <li> वेब डिज़ाइन</li>
                                                </ul>',
                        'button_text'       => 'यह योजना चुनें',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'plan_name'         => 'بدء',
                        'short_description' => 'نحن نهتم بنجاحهم. بالنسبة لنا، العلاقات الحقيقية تغذي الواقع.',
                        'description'       => '<ul>
                                                <li>الويب والهواتف المحمولة</li>
                                                <li>نطاق مخصص مجاني</li>
                                                <li>أفضل استضافة على الإطلاق</li>
                                                <li>دعم متميز</li>
                                                <li>تصميم الويب</li>
                                                </ul>',
                        'button_text'       => 'اختر هذه الخطة',
                    ],
                ],
            ],
            [
                'plan_price'      => 280,
                'expiration_date' => 'yearly', //yearly lifetime monthly
                'translations' => [
                    [
                        'lang_code'         => 'en',
                        'plan_name'         => 'Yearly Plan',
                        'short_description' => 'We care about their success. For us real relationships fuel real',
                        'description'       => '<ul>
                                                <li> Web & Mobile</li>
                                                <li> Free Custom Domain</li>
                                                <li> Best Hosting Ever</li>
                                                <li> Outstanding Support</li>
                                                <li> Web Design</li>
                                                </ul>',
                        'button_text'       => 'Choose This Plan',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'plan_name'         => 'वार्षिक योजना',
                        'short_description' => 'हम उनकी सफलता की परवाह करते हैं। हमारे लिए सच्चे रिश्ते ही असली प्रेरणा देते हैं',
                        'description'       => '<ul>
                                                <li> वेब और मोबाइल</li>
                                                <li> निःशुल्क कस्टम डोमेन</li>
                                                <li> अब तक की सर्वश्रेष्ठ होस्टिंग</li>
                                                <li> उत्कृष्ट सहायता</li>
                                                <li> वेब डिज़ाइन</li>
                                                </ul>',
                        'button_text'       => 'यह योजना चुनें',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'plan_name'         => 'الخطة السنوية',
                        'short_description' => 'نحن نهتم بنجاحهم. بالنسبة لنا، العلاقات الحقيقية تغذي الواقع.',
                        'description'       => '<ul>
                                                <li>الويب والهواتف المحمولة</li>
                                                <li>نطاق مخصص مجاني</li>
                                                <li>أفضل استضافة على الإطلاق</li>
                                                <li>دعم متميز</li>
                                                <li>تصميم الويب</li>
                                                </ul>',
                        'button_text'       => 'اختر هذه الخطة',
                    ],
                ],
            ],
            [
                'plan_price'      => 450,
                'expiration_date' => 'lifetime', //yearly lifetime monthly
                'translations' => [
                    [
                        'lang_code'         => 'en',
                        'plan_name'         => 'Lifetime Plan',
                        'short_description' => 'We care about their success. For us real relationships fuel real',
                        'description'       => '<ul>
                                                <li> Web & Mobile</li>
                                                <li> Free Custom Domain</li>
                                                <li> Best Hosting Ever</li>
                                                <li> Outstanding Support</li>
                                                <li> Web Design</li>
                                                </ul>',
                        'button_text'       => 'Choose This Plan',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'plan_name'         => 'आजीवन योजना',
                        'short_description' => 'हम उनकी सफलता की परवाह करते हैं। हमारे लिए सच्चे रिश्ते ही असली प्रेरणा देते हैं',
                        'description'       => '<ul>
                                                <li> वेब और मोबाइल</li>
                                                <li> निःशुल्क कस्टम डोमेन</li>
                                                <li> अब तक की सर्वश्रेष्ठ होस्टिंग</li>
                                                <li> उत्कृष्ट सहायता</li>
                                                <li> वेब डिज़ाइन</li>
                                                </ul>',
                        'button_text'       => 'यह योजना चुनें',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'plan_name'         => 'خطة مدى الحياة',
                        'short_description' => 'نحن نهتم بنجاحهم. بالنسبة لنا، العلاقات الحقيقية تغذي الواقع.',
                        'description'       => '<ul>
                                                <li>الويب والهواتف المحمولة</li>
                                                <li>نطاق مخصص مجاني</li>
                                                <li>أفضل استضافة على الإطلاق</li>
                                                <li>دعم متميز</li>
                                                <li>تصميم الويب</li>
                                                </ul>',
                        'button_text'       => 'اختر هذه الخطة',
                    ],
                ],
            ],
        ];

        foreach ($dummyData as $index => $value) {
            $plan = new SubscriptionPlan();
            $plan->plan_price = $value['plan_price'];
            $plan->expiration_date = $value['expiration_date'];
            $plan->button_url = "https://websolutionus.com";
            $plan->serial = ++$index;
            $plan->status = true;

            $plan->save();

            foreach ($value['translations'] as $data) {
                $planTranslation = new SubscriptionPlanTranslation();
                $planTranslation->subscription_plan_id = $plan->id;
                $planTranslation->lang_code = $data['lang_code'];
                $planTranslation->plan_name = $data['plan_name'];
                $planTranslation->short_description = $data['short_description'];
                $planTranslation->description = $data['description'];
                $planTranslation->button_text = $data['button_text'];
                $planTranslation->save();
            }
        }
    }
}
