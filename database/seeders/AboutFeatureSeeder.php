<?php

namespace Database\Seeders;

use App\Models\AboutFeature;
use App\Models\AboutFeatureTranslation;
use Illuminate\Database\Seeder;

class AboutFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'icon' => 'fas fa-lightbulb',
                'order' => 1,
                'status' => true,
                'translations' => [
                    [
                        'lang_code' => 'en',
                        'title' => 'Creative Solutions',
                        'description' => 'We provide innovative and creative solutions tailored to your business needs.'
                    ],
                    [
                        'lang_code' => 'hi',
                        'title' => 'रचनात्मक समाधान',
                        'description' => 'हम आपकी व्यावसायिक आवश्यकताओं के अनुकूल नवाचार और रचनात्मक समाधान प्रदान करते हैं।'
                    ],
                    [
                        'lang_code' => 'ar',
                        'title' => 'حلول إبداعية',
                        'description' => 'نحن نقدم حلولاً مبتكرة وإبداعية مصممة خصيصاً لتلبية احتياجات عملك.'
                    ]
                ]
            ],
            [
                'icon' => 'fas fa-users',
                'order' => 2,
                'status' => true,
                'translations' => [
                    [
                        'lang_code' => 'en',
                        'title' => 'Expert Team',
                        'description' => 'Our team consists of experienced professionals dedicated to delivering excellence.'
                    ],
                    [
                        'lang_code' => 'hi',
                        'title' => 'विशेषज्ञ टीम',
                        'description' => 'हमारी टीम अनुभवी पेशेवरों से मिलकर बनी है जो उत्कृष्टता प्रदान करने के लिए समर्पित हैं।'
                    ],
                    [
                        'lang_code' => 'ar',
                        'title' => 'فريق خبراء',
                        'description' => 'يتكون فريقنا من محترفين ذوي خبرة مكرسين لتقديم التميز.'
                    ]
                ]
            ],
            [
                'icon' => 'fas fa-clock',
                'order' => 3,
                'status' => true,
                'translations' => [
                    [
                        'lang_code' => 'en',
                        'title' => 'Timely Delivery',
                        'description' => 'We ensure all projects are completed on time without compromising quality.'
                    ],
                    [
                        'lang_code' => 'hi',
                        'title' => 'समय पर डिलीवरी',
                        'description' => 'हम सुनिश्चित करते हैं कि सभी परियोजनाएं गुणवत्ता से समझौता किए बिना समय पर पूरी हों।'
                    ],
                    [
                        'lang_code' => 'ar',
                        'title' => 'التسليم في الوقت المحدد',
                        'description' => 'نحن نضمن إنجاز جميع المشاريع في الوقت المحدد دون التنازل عن الجودة.'
                    ]
                ]
            ],
            [
                'icon' => 'fas fa-shield-alt',
                'order' => 4,
                'status' => true,
                'translations' => [
                    [
                        'lang_code' => 'en',
                        'title' => 'Quality Assurance',
                        'description' => 'We maintain the highest standards of quality in all our deliverables.'
                    ],
                    [
                        'lang_code' => 'hi',
                        'title' => 'गुणवत्ता आश्वासन',
                        'description' => 'हम अपनी सभी डिलिवरेबल्स में गुणवत्ता के उच्चतम मानकों को बनाए रखते हैं।'
                    ],
                    [
                        'lang_code' => 'ar',
                        'title' => 'ضمان الجودة',
                        'description' => 'نحن نحافظ على أعلى معايير الجودة في جميع مخرجاتنا.'
                    ]
                ]
            ]
        ];

        foreach ($features as $featureData) {
            $feature = AboutFeature::create([
                'icon' => $featureData['icon'],
                'order' => $featureData['order'],
                'status' => $featureData['status']
            ]);

            foreach ($featureData['translations'] as $translation) {
                AboutFeatureTranslation::create([
                    'about_feature_id' => $feature->id,
                    'lang_code' => $translation['lang_code'],
                    'title' => $translation['title'],
                    'description' => $translation['description']
                ]);
            }
        }
    }
}