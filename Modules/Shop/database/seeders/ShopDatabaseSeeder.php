<?php

namespace Modules\Shop\database\seeders;

use App\Models\Admin;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductCategory;
use Modules\Shop\app\Models\ProductCategoryTranslation;
use Modules\Shop\app\Models\ProductImage;
use Modules\Shop\app\Models\ProductReview;
use Modules\Shop\app\Models\ProductTranslation;

class ShopDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Faker::create();

        $dummyCategories = [
            [
                'slug'         => 'smartphones',
                'translations' => [
                    ['lang_code' => 'en', 'title' => 'Smartphones'],
                    ['lang_code' => 'hi', 'title' => 'स्मार्टफोन'],
                    ['lang_code' => 'ar', 'title' => 'الهواتف الذكية'],
                ],
            ],
            [
                'slug'         => 'laptops',
                'translations' => [
                    ['lang_code' => 'en', 'title' => 'Laptops'],
                    ['lang_code' => 'hi', 'title' => 'लैपटॉप'],
                    ['lang_code' => 'ar', 'title' => 'أجهزة الكمبيوتر المحمولة'],
                ],
            ],
            [
                'slug'         => 'accessories',
                'translations' => [
                    ['lang_code' => 'en', 'title' => 'Accessories'],
                    ['lang_code' => 'hi', 'title' => 'सामान'],
                    ['lang_code' => 'ar', 'title' => 'مُكَمِّلات'],
                ],
            ],
            [
                'slug'         => 'furniture',
                'translations' => [
                    ['lang_code' => 'en', 'title' => 'Furniture'],
                    ['lang_code' => 'hi', 'title' => 'फर्नीचर'],
                    ['lang_code' => 'ar', 'title' => 'أثاث'],
                ],
            ],
            [
                'slug'         => 'fashion',
                'translations' => [
                    ['lang_code' => 'en', 'title' => 'Fashion'],
                    ['lang_code' => 'hi', 'title' => 'पहनावा'],
                    ['lang_code' => 'ar', 'title' => 'موضة'],
                ],
            ],
            [
                'slug'         => 'script',
                'translations' => [
                    ['lang_code' => 'en', 'title' => 'Script'],
                    ['lang_code' => 'hi', 'title' => 'लिखी हुई कहानी'],
                    ['lang_code' => 'ar', 'title' => 'نص'],
                ],
            ],
        ];
        foreach ($dummyCategories as $item) {
            $category = new ProductCategory();
            $category->slug = $item['slug'];
            $category->position = $faker->numberBetween(0, 30);
            $category->parent_id = null;
            $category->status = 1;
            $category->save();

            foreach ($item['translations'] as $translattion) {
                $categoryTranslation = new ProductCategoryTranslation();
                $categoryTranslation->product_category_id = $category->id;
                $categoryTranslation->lang_code = $translattion['lang_code'];
                $categoryTranslation->title = $translattion['title'];
                $categoryTranslation->save();
            }
        }

        // products
        $dummyProducts = [
            [
                'slug'             => 'hydrasip-water-bottle',
                'image'            => 'uploads/website-images/product/bottle_1.png',
                'status'           => true,
                'product_category_id' => 3,
                'price'            => 15,
                'sale_price'       => 12,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'HydraSip Water Bottle',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Stay hydrated on the go with our HydraSip Water Bottle. Sleek, durable, and leak-proof, it\'s perfect for all your adventures.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'HydraSip Water Bottle',
                        'description'       => 'टिकाऊ और स्टाइलिश, हाइड्रा सिप वॉटर बॉटल आपके दैनिक जलयोजन की जरूरतों के लिए एकदम सही साथी है।',
                        'short_description' => 'सभी रोमांचों के लिए लीक-प्रूफ और स्टाइलिश हाइड्रा सिप वॉटर बॉटल के साथ हाइड्रेटेड रहें।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'HydraSip Water Bottle',
                        'description'       => 'متينة وأنيقة، زجاجة مياه HydraSip هي الرفيق المثالي لترطيبك اليومي.',
                        'short_description' => 'حافظ على رطوبتك أثناء التنقل مع زجاجة المياه HydraSip. أنيق ومتين ومضاد للتسرب.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/bottle_1.png',
                    'uploads/website-images/product/bottle_2.png',
                    'uploads/website-images/product/bottle_3.png',
                    'uploads/website-images/product/bottle_4.png',
                    'uploads/website-images/product/bottle_5.png',
                ],
            ],
            [
                'slug'             => 'eco-friendly-bottle',
                'image'            => 'uploads/website-images/product/bottle_2.png',
                'status'           => true,
                'product_category_id' => 3,
                'price'            => 18,
                'sale_price'       => null,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'Eco-Friendly Water Bottle',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Made from sustainable materials, this eco-friendly water bottle is perfect for the environmentally conscious.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'Eco-Friendly Water Bottle',
                        'description'       => 'सस्टेनेबल सामग्री से बनी, यह ईको-फ्रेंडली वॉटर बॉटल पर्यावरण के प्रति सचेत लोगों के लिए आदर्श है।',
                        'short_description' => 'सस्टेनेबल सामग्री से बनी पर्यावरण-अनुकूल वॉटर बॉटल के साथ हाइड्रेटेड और जिम्मेदार रहें।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'Eco-Friendly Water Bottle',
                        'description'       => 'مصنوعة من مواد مستدامة، هذه الزجاجة هي الخيار المثالي لمن يهتمون بالبيئة.',
                        'short_description' => 'حافظ على ترطيبك بمسؤولية مع زجاجة المياه الصديقة للبيئة المصنوعة من مواد مستدامة.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/bottle_2.png',
                    'uploads/website-images/product/bottle_1.png',
                    'uploads/website-images/product/bottle_3.png',
                    'uploads/website-images/product/bottle_4.png',
                    'uploads/website-images/product/bottle_5.png',
                ],
            ],
            [
                'slug'             => 'watch',
                'image'            => 'uploads/website-images/product/watch_1.png',
                'status'           => true,
                'product_category_id' => 5,
                'price' => 35,
                'sale_price' => null,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Watch',
                        'description'            => "Discover the perfect blend of style, sophistication, and precision with the Elegance Watch. This meticulously crafted timepiece is designed to complement any outfit and enhance your personal style. Whether you're attending a formal event, heading to the office, or enjoying a casual day out, the Elegance Watch is your ideal companion.<br/><br/>
<strong>Premium Design:</strong> The Elegance Watch features a sleek and timeless design, with a polished stainless steel case and a scratch-resistant sapphire crystal face. Its minimalist dial and elegant hands make it a versatile accessory for any occasion.<br/><br/>
<strong>Superior Craftsmanship:</strong> Crafted with attention to detail, the watch boasts a high-precision quartz movement, ensuring accurate timekeeping. The durable construction and quality materials guarantee long-lasting performance.<br/><br/>
<strong>Comfortable Fit:</strong> The adjustable leather strap provides a comfortable and secure fit, allowing you to wear the watch all day with ease. The strap is available in various colors to match your personal style.<br/><br/>
<strong>Water-Resistant:</strong> With a water resistance of up to 50 meters, the Elegance Watch is suitable for everyday wear, including hand washing and light splashes. Enjoy peace of mind knowing your watch can handle daily activities.<br/><br/>
<strong>Versatile Functionality:</strong> In addition to displaying the time, the Elegance Watch includes a date function, adding practicality to its elegant design. Stay organized and on schedule with this reliable feature.<br/><br/>
<strong>Gift-Ready Packaging:</strong> The Elegance Watch comes in a beautifully crafted box, making it a perfect gift for birthdays, anniversaries, or special occasions. Surprise your loved ones with a timeless piece they will cherish.<br/><br/>
Elevate your style with the Elegance Watch, a testament to fine craftsmanship and timeless design. Embrace sophistication and reliability, all in one stunning timepiece.",
                        'short_description'      => 'Experience timeless style and precision with the Elegance Watch. Crafted for sophistication and durability, this watch is perfect for any occasion.',
                        
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Watch',
                        'description'            => "एलिगेंस वॉच के साथ स्टाइल, परिष्कार और सटीकता का सही मिश्रण पाएँ। यह सावधानीपूर्वक तैयार की गई घड़ी किसी भी पोशाक के पूरक और आपकी व्यक्तिगत शैली को बढ़ाने के लिए डिज़ाइन की गई है। चाहे आप किसी औपचारिक कार्यक्रम में भाग ले रहे हों, कार्यालय जा रहे हों, या किसी आकस्मिक दिन का आनंद ले रहे हों, एलिगेंस वॉच आपका आदर्श साथी है।<br/><br/>
<strong>प्रीमियम डिज़ाइन:</strong> एलिगेंस वॉच में एक चिकना और कालातीत डिज़ाइन है, जिसमें पॉलिश किया हुआ स्टेनलेस स्टील केस और स्क्रैच-प्रतिरोधी नीलम क्रिस्टल फेस है। इसका मिनिमलिस्ट डायल और सुरुचिपूर्ण हाथ इसे किसी भी अवसर के लिए एक बहुमुखी एक्सेसरी बनाते हैं।<br/><br/>
<strong>बेहतरीन शिल्प कौशल:</strong> विस्तार से ध्यान देने के साथ तैयार की गई, घड़ी में एक उच्च-परिशुद्धता क्वार्ट्ज मूवमेंट है, जो सटीक समय सुनिश्चित करता है। टिकाऊ निर्माण और गुणवत्ता वाली सामग्री लंबे समय तक चलने वाले प्रदर्शन की गारंटी देती है।<br/><br/>
<strong>आरामदायक फिट:</strong> समायोज्य चमड़े का पट्टा एक आरामदायक और सुरक्षित फिट प्रदान करता है, जिससे आप पूरे दिन आसानी से घड़ी पहन सकते हैं। पट्टा आपकी व्यक्तिगत शैली से मेल खाने के लिए विभिन्न रंगों में उपलब्ध है।<br/><br/>
<strong>जल प्रतिरोधी:</strong> 50 मीटर तक के जल प्रतिरोध के साथ, एलिगेंस वॉच रोज़ाना पहनने के लिए उपयुक्त है, जिसमें हाथ धोना और हल्की छींटे शामिल हैं। यह जानकर मन की शांति का आनंद लें कि आपकी घड़ी दैनिक गतिविधियों को संभाल सकती है।<br/><br/>
<strong>बहुमुखी कार्यक्षमता:</strong> समय प्रदर्शित करने के अलावा, एलिगेंस वॉच में एक दिनांक फ़ंक्शन भी शामिल है, जो इसके सुरुचिपूर्ण डिज़ाइन में व्यावहारिकता जोड़ता है। इस विश्वसनीय सुविधा के साथ व्यवस्थित और शेड्यूल पर रहें।",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                        
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Watch',
                        'description'            => "اكتشف المزيج المثالي من الأناقة والرقي والدقة مع ساعة Elegance Watch. تم تصميم هذه الساعة المصممة بدقة لتكمل أي ملابس وتعزز أسلوبك الشخصي. سواء كنت تحضر مناسبة رسمية، أو تتجه إلى المكتب، أو تستمتع بيوم غير رسمي، فإن ساعة Elegance هي رفيقك المثالي.<br/><br/>
<strong>تصميم متميز:</strong> تتميز ساعة Elegance بتصميم أنيق وخالد، مع علبة مصقولة من الفولاذ المقاوم للصدأ ووجه من كريستال الياقوت المقاوم للخدش. كما أن قرصه البسيط وعقاربه الأنيقة تجعله إكسسوارًا متعدد الاستخدامات لأي مناسبة.<br/><br/>
<strong>حرفية فائقة:</strong> صُنعت الساعة مع الاهتمام بالتفاصيل، وتتميز بحركة كوارتز عالية الدقة، مما يضمن حفظ الوقت بدقة. يضمن البناء المتين والمواد عالية الجودة أداءً طويل الأمد.<br/><br/>
<strong>ملاءمة مريحة:</strong> يوفر الحزام الجلدي القابل للتعديل ملاءمة مريحة وآمنة، مما يسمح لك بارتداء الساعة طوال اليوم بسهولة. الحزام متوفر بألوان مختلفة ليناسب ذوقك الشخصي.<br/><br/>
<strong>مقاومة للماء:</strong> مع مقاومة للماء حتى عمق 50 مترًا، تعد ساعة Elegance مناسبة للارتداء اليومي، بما في ذلك غسل اليدين والرذاذ الخفيف. استمتع براحة البال عندما تعلم أن ساعتك يمكنها التعامل مع الأنشطة اليومية.<br/><br/>
<strong>وظائف متعددة الاستخدامات:</strong> بالإضافة إلى عرض الوقت، تشتمل ساعة Elegance Watch على وظيفة التاريخ، مما يضيف التطبيق العملي إلى تصميمها الأنيق. كن منظمًا وفي الموعد المحدد باستخدام هذه الميزة الموثوقة.<br/><br/>
<strong>تغليف جاهز للهدايا:</strong> تأتي ساعة Elegance Watch في صندوق مصنوع بشكل جميل، مما يجعلها هدية مثالية لأعياد الميلاد أو الذكرى السنوية أو المناسبات الخاصة. فاجئ أحبائك بقطعة خالدة سيعتزون بها.<br/><br/>
ارفع من أسلوبك مع ساعة Elegance Watch، وهي شهادة على الحرفية الدقيقة والتصميم الخالد. استمتع بالرقي والموثوقية، كل ذلك في ساعة واحدة مذهلة.",
                        'short_description'      => 'استمتع بالأناقة والدقة الخالدة مع ساعة Elegance. صُنعت هذه الساعة من أجل الرقي والمتانة، وهي مثالية لأي مناسبة.',
                        
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/watch_1.png',
                    'uploads/website-images/product/watch_2.png',
                    'uploads/website-images/product/watch_3.png',
                    'uploads/website-images/product/watch_2.png',
                ],
            ],
            [
                'slug'             => 'winter-jacket',
                'image'            => 'uploads/website-images/product/jacket_1.png',
                'status'           => true,
                'product_category_id' => 5,
                'price' => 48,
                'sale_price' => null,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Winter Jacket',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Conquer the cold with our ArcticShield Winter Jacket. Waterproof, insulated, and stylish, it\'s your essential companion for chilly adventures.',
                       
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Winter Jacket',
                        'description'            => "एलिगेंस वॉच के साथ स्टाइल, परिष्कार और सटीकता का सही मिश्रण पाएँ। यह सावधानीपूर्वक तैयार की गई घड़ी किसी भी पोशाक के पूरक और आपकी व्यक्तिगत शैली को बढ़ाने के लिए डिज़ाइन की गई है। चाहे आप किसी औपचारिक कार्यक्रम में भाग ले रहे हों, कार्यालय जा रहे हों, या किसी आकस्मिक दिन का आनंद ले रहे हों, एलिगेंस वॉच आपका आदर्श साथी है।<br/><br/>
<strong>प्रीमियम डिज़ाइन:</strong> एलिगेंस वॉच में एक चिकना और कालातीत डिज़ाइन है, जिसमें पॉलिश किया हुआ स्टेनलेस स्टील केस और स्क्रैच-प्रतिरोधी नीलम क्रिस्टल फेस है। इसका मिनिमलिस्ट डायल और सुरुचिपूर्ण हाथ इसे किसी भी अवसर के लिए एक बहुमुखी एक्सेसरी बनाते हैं।<br/><br/>
<strong>बेहतरीन शिल्प कौशल:</strong> विस्तार से ध्यान देने के साथ तैयार की गई, घड़ी में एक उच्च-परिशुद्धता क्वार्ट्ज मूवमेंट है, जो सटीक समय सुनिश्चित करता है। टिकाऊ निर्माण और गुणवत्ता वाली सामग्री लंबे समय तक चलने वाले प्रदर्शन की गारंटी देती है।<br/><br/>
<strong>आरामदायक फिट:</strong> समायोज्य चमड़े का पट्टा एक आरामदायक और सुरक्षित फिट प्रदान करता है, जिससे आप पूरे दिन आसानी से घड़ी पहन सकते हैं। पट्टा आपकी व्यक्तिगत शैली से मेल खाने के लिए विभिन्न रंगों में उपलब्ध है।<br/><br/>
<strong>जल प्रतिरोधी:</strong> 50 मीटर तक के जल प्रतिरोध के साथ, एलिगेंस वॉच रोज़ाना पहनने के लिए उपयुक्त है, जिसमें हाथ धोना और हल्की छींटे शामिल हैं। यह जानकर मन की शांति का आनंद लें कि आपकी घड़ी दैनिक गतिविधियों को संभाल सकती है।<br/><br/>
<strong>बहुमुखी कार्यक्षमता:</strong> समय प्रदर्शित करने के अलावा, एलिगेंस वॉच में एक दिनांक फ़ंक्शन भी शामिल है, जो इसके सुरुचिपूर्ण डिज़ाइन में व्यावहारिकता जोड़ता है। इस विश्वसनीय सुविधा के साथ व्यवस्थित और शेड्यूल पर रहें।",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                       
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Winter Jacket',
                        'description'            => "و ككل و أ. فمن رضي بواجباته فله متعة عظيمة وعظيمة. ولذلك تم اختياره لأنه كان هنا.\n\nإنها مسألة متعة وليست حادثة مفيدة. من هو حكيم مع واجبات أقل فهو هنا. يكره أن يتحمل العواقب فهو لا يعلم إن كانت ستحدث أم لا.\n\nلأنه يريد ما لا يدفع الألم إلا باللذات. لا بد من إنقاذه، أو أن الآلام التي يجب أن يعاني منها تكون مفيدة. لأن من يقدمها هو هو.\n\nأما الحكيم فينتقد الأسلوب المتعب. لمن يرغب أو حتى أصغر. فقبضوا عليه ولاذوا بالفرار.",
                        'short_description'      => 'تغلب على البرد مع سترة ArcticShield الشتوية الخاصة بنا. مقاوم للماء، ومعزول، وأنيق، إنه رفيقك الأساسي للمغامرات الباردة.',
                        
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/jacket_1.png',
                    'uploads/website-images/product/jacket_2.png',
                    'uploads/website-images/product/jacket_3.png',
                    'uploads/website-images/product/jacket_2.png',
                ],
            ],
            [
                'slug'             => 'bag',
                'image'            => 'uploads/website-images/product/bag_1.png',
                'status'           => true,
                'product_category_id' => 5,
                'price' => 29,
                'sale_price' => 24,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Bag',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Stay organized and chic with our Stylish Crossbody Bag. Perfect for daily essentials, it blends fashion with functionality seamlessly.',
                       
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Bag',
                        'description'            => "एलिगेंस वॉच के साथ स्टाइल, परिष्कार और सटीकता का सही मिश्रण पाएँ। यह सावधानीपूर्वक तैयार की गई घड़ी किसी भी पोशाक के पूरक और आपकी व्यक्तिगत शैली को बढ़ाने के लिए डिज़ाइन की गई है। चाहे आप किसी औपचारिक कार्यक्रम में भाग ले रहे हों, कार्यालय जा रहे हों, या किसी आकस्मिक दिन का आनंद ले रहे हों, एलिगेंस वॉच आपका आदर्श साथी है।<br/><br/>
<strong>प्रीमियम डिज़ाइन:</strong> एलिगेंस वॉच में एक चिकना और कालातीत डिज़ाइन है, जिसमें पॉलिश किया हुआ स्टेनलेस स्टील केस और स्क्रैच-प्रतिरोधी नीलम क्रिस्टल फेस है। इसका मिनिमलिस्ट डायल और सुरुचिपूर्ण हाथ इसे किसी भी अवसर के लिए एक बहुमुखी एक्सेसरी बनाते हैं।<br/><br/>
<strong>बेहतरीन शिल्प कौशल:</strong> विस्तार से ध्यान देने के साथ तैयार की गई, घड़ी में एक उच्च-परिशुद्धता क्वार्ट्ज मूवमेंट है, जो सटीक समय सुनिश्चित करता है। टिकाऊ निर्माण और गुणवत्ता वाली सामग्री लंबे समय तक चलने वाले प्रदर्शन की गारंटी देती है।<br/><br/>
<strong>आरामदायक फिट:</strong> समायोज्य चमड़े का पट्टा एक आरामदायक और सुरक्षित फिट प्रदान करता है, जिससे आप पूरे दिन आसानी से घड़ी पहन सकते हैं। पट्टा आपकी व्यक्तिगत शैली से मेल खाने के लिए विभिन्न रंगों में उपलब्ध है।<br/><br/>
<strong>जल प्रतिरोधी:</strong> 50 मीटर तक के जल प्रतिरोध के साथ, एलिगेंस वॉच रोज़ाना पहनने के लिए उपयुक्त है, जिसमें हाथ धोना और हल्की छींटे शामिल हैं। यह जानकर मन की शांति का आनंद लें कि आपकी घड़ी दैनिक गतिविधियों को संभाल सकती है।<br/><br/>
<strong>बहुमुखी कार्यक्षमता:</strong> समय प्रदर्शित करने के अलावा, एलिगेंस वॉच में एक दिनांक फ़ंक्शन भी शामिल है, जो इसके सुरुचिपूर्ण डिज़ाइन में व्यावहारिकता जोड़ता है। इस विश्वसनीय सुविधा के साथ व्यवस्थित और शेड्यूल पर रहें।",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                       
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Bag',
                        'description'            => "و ككل و أ. فمن رضي بواجباته فله متعة عظيمة وعظيمة. ولذلك تم اختياره لأنه كان هنا.\n\nإنها مسألة متعة وليست حادثة مفيدة. من هو حكيم مع واجبات أقل فهو هنا. يكره أن يتحمل العواقب فهو لا يعلم إن كانت ستحدث أم لا.\n\nلأنه يريد ما لا يدفع الألم إلا باللذات. لا بد من إنقاذه، أو أن الآلام التي يجب أن يعاني منها تكون مفيدة. لأن من يقدمها هو هو.\n\nأما الحكيم فينتقد الأسلوب المتعب. لمن يرغب أو حتى أصغر. فقبضوا عليه ولاذوا بالفرار.",
                        'short_description'      => 'ابق منظمًا وأنيقًا مع حقيبة كروس الأنيقة الخاصة بنا. مثالي للضروريات اليومية، فهو يمزج بين الموضة والأداء بسلاسة.',
                    ],
                ],
                'extra_image'      => [

                    'uploads/website-images/product/bag_1.png',
                    'uploads/website-images/product/bag_2.png',
                    'uploads/website-images/product/bag_3.png',
                    'uploads/website-images/product/bag_4.png',
                ],
            ],
            [
                'slug'             => 'stylish-t-shirt',
                'image'            => 'uploads/website-images/product/T-shirt_1.png',
                'status'           => true,
                'product_category_id' => 5,
                'price' => 22,
                'sale_price' => null,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Stylish T-Shirt',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => "Elevate your casual wardrobe with our Essential Style T-Shirt. Crafted for comfort and versatility, it pairs effortlessly with any outfit.",
                        
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Stylish T-Shirt',
                        'description'            => "एलिगेंस वॉच के साथ स्टाइल, परिष्कार और सटीकता का सही मिश्रण पाएँ। यह सावधानीपूर्वक तैयार की गई घड़ी किसी भी पोशाक के पूरक और आपकी व्यक्तिगत शैली को बढ़ाने के लिए डिज़ाइन की गई है। चाहे आप किसी औपचारिक कार्यक्रम में भाग ले रहे हों, कार्यालय जा रहे हों, या किसी आकस्मिक दिन का आनंद ले रहे हों, एलिगेंस वॉच आपका आदर्श साथी है।<br/><br/>
<strong>प्रीमियम डिज़ाइन:</strong> एलिगेंस वॉच में एक चिकना और कालातीत डिज़ाइन है, जिसमें पॉलिश किया हुआ स्टेनलेस स्टील केस और स्क्रैच-प्रतिरोधी नीलम क्रिस्टल फेस है। इसका मिनिमलिस्ट डायल और सुरुचिपूर्ण हाथ इसे किसी भी अवसर के लिए एक बहुमुखी एक्सेसरी बनाते हैं।<br/><br/>
<strong>बेहतरीन शिल्प कौशल:</strong> विस्तार से ध्यान देने के साथ तैयार की गई, घड़ी में एक उच्च-परिशुद्धता क्वार्ट्ज मूवमेंट है, जो सटीक समय सुनिश्चित करता है। टिकाऊ निर्माण और गुणवत्ता वाली सामग्री लंबे समय तक चलने वाले प्रदर्शन की गारंटी देती है।<br/><br/>
<strong>आरामदायक फिट:</strong> समायोज्य चमड़े का पट्टा एक आरामदायक और सुरक्षित फिट प्रदान करता है, जिससे आप पूरे दिन आसानी से घड़ी पहन सकते हैं। पट्टा आपकी व्यक्तिगत शैली से मेल खाने के लिए विभिन्न रंगों में उपलब्ध है।<br/><br/>
<strong>जल प्रतिरोधी:</strong> 50 मीटर तक के जल प्रतिरोध के साथ, एलिगेंस वॉच रोज़ाना पहनने के लिए उपयुक्त है, जिसमें हाथ धोना और हल्की छींटे शामिल हैं। यह जानकर मन की शांति का आनंद लें कि आपकी घड़ी दैनिक गतिविधियों को संभाल सकती है।<br/><br/>
<strong>बहुमुखी कार्यक्षमता:</strong> समय प्रदर्शित करने के अलावा, एलिगेंस वॉच में एक दिनांक फ़ंक्शन भी शामिल है, जो इसके सुरुचिपूर्ण डिज़ाइन में व्यावहारिकता जोड़ता है। इस विश्वसनीय सुविधा के साथ व्यवस्थित और शेड्यूल पर रहें।",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                       
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Stylish T-Shirt',
                        'description'            => "و ككل و أ. فمن رضي بواجباته فله متعة عظيمة وعظيمة. ولذلك تم اختياره لأنه كان هنا.\n\nإنها مسألة متعة وليست حادثة مفيدة. من هو حكيم مع واجبات أقل فهو هنا. يكره أن يتحمل العواقب فهو لا يعلم إن كانت ستحدث أم لا.\n\nلأنه يريد ما لا يدفع الألم إلا باللذات. لا بد من إنقاذه، أو أن الآلام التي يجب أن يعاني منها تكون مفيدة. لأن من يقدمها هو هو.\n\nأما الحكيم فينتقد الأسلوب المتعب. لمن يرغب أو حتى أصغر. فقبضوا عليه ولاذوا بالفرار.",
                        'short_description'      => 'ارفع خزانة ملابسك غير الرسمية مع تي شيرت Essential Style الخاص بنا. مصنوع من أجل الراحة والتنوع، فهو يتماشى بسهولة مع أي ملابس.',
                       
                    ],
                ],
                'extra_image'      => [

                    'uploads/website-images/product/T-shirt_1.png',
                    'uploads/website-images/product/T-shirt_2.png',
                    'uploads/website-images/product/T-shirt_3.png',
                    'uploads/website-images/product/T-shirt_4.png',
                ],
            ],
            [
                'slug'             => 'executive-chair',
                'image'            => 'uploads/website-images/product/chair_1.png',
                'status'           => true,
                'product_category_id' => 4,
                'price'            => 129,
                'sale_price'       => 99,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'Executive Chair',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Premium executive chair designed for comfort and style, perfect for long office hours.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'Executive Chair',
                        'description'       => 'आराम और स्टाइल का सही मेल, यह प्रीमियम कार्यकारी कुर्सी लंबे कार्य घंटों के लिए उपयुक्त है।',
                        'short_description' => 'आराम और दक्षता के लिए डिज़ाइन की गई, हमारी कार्यकारी कुर्सी आपके कार्यक्षेत्र में शानदार जोड़ है।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'Executive Chair',
                        'description'       => 'كرسي تنفيذي متميز مصمم للراحة والأناقة، مثالي لساعات العمل الطويلة في المكتب.',
                        'short_description' => 'اجعل عملك أكثر راحة مع كرسي المكتب الفاخر المصمم ليدوم طويلاً.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/chair_1.png',
                    'uploads/website-images/product/chair_2.png',
                    'uploads/website-images/product/chair_3.png',
                    'uploads/website-images/product/chair_4.png',
                ],
            ],
            [
                'slug'             => 'sectional-sofa',
                'image'            => 'uploads/website-images/product/chair_7.png',
                'status'           => true,
                'product_category_id' => 4,
                'price'            => 699,
                'sale_price'       => 599,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'Sectional Sofa',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Spacious sectional sofa with modular design, perfect for modern living rooms.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'Sectional Sofa',
                        'description'       => 'विशाल और आधुनिक डिज़ाइन के साथ, यह सेक्शनल सोफा आपके घर के लिए एक बढ़िया विकल्प है।',
                        'short_description' => 'आराम और शैली का सही संतुलन प्रदान करने वाला आधुनिक सेक्शनल सोफा।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'Sectional Sofa',
                        'description'       => 'كنبة مقطعية فسيحة بتصميم مرن، مثالية لغرف المعيشة الحديثة.',
                        'short_description' => 'استمتع بالراحة القصوى مع كنبة مقطعية قابلة للتعديل لتناسب مساحتك.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/chair_7.png',
                    'uploads/website-images/product/chair_6.png',
                    'uploads/website-images/product/chair_3.png',
                    'uploads/website-images/product/chair_6.png',
                ],
            ],
            [
                'slug'             => 'fast-charge-power-bank',
                'image'            => 'uploads/website-images/product/power_bank_4.png',
                'status'           => true,
                'product_category_id' => 3,
                'price'            => 25,
                'sale_price'       => 22,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Fast Charge Power Bank',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Power up your devices at lightning speed with our Fast Charge Power Bank. High-capacity and quick charging for your daily needs.',
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Fast Charge Power Bank',
                        'description'            => 'बिजली की गति से अपने डिवाइसेस चार्ज करें! हमारा फास्ट चार्ज पावर बैंक उच्च क्षमता और त्वरित चार्जिंग तकनीक से लैस है।',
                        'short_description'      => 'अत्यधिक क्षमता और त्वरित चार्जिंग तकनीक के साथ।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Fast Charge Power Bank',
                        'description'            => 'اشحن أجهزتك بسرعة فائقة مع بنك طاقة الشحن السريع. سعة عالية وتقنية شحن متقدمة لراحتك اليومية.',
                        'short_description'      => 'سعة كبيرة وشحن سريع لكل احتياجاتك.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/power_bank_4.png',
                    'uploads/website-images/product/power_bank_2.png',
                    'uploads/website-images/product/power_bank_3.png',
                    'uploads/website-images/product/power_bank_2.png',
                ],
            ],
            [
                'slug'             => 'oneplus-12',
                'image'            => 'uploads/website-images/product/smartphone_7.png',
                'status'           => true,
                'product_category_id' => 1,
                'price' => 169,
                'sale_price' => 129,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'OnePlus 12',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Flagship performance meets stunning design with the OnePlus 12. Ultra-fast Snapdragon 8 Gen 3 processor and 120Hz AMOLED display.',
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'OnePlus 12',
                        'description'            => 'वनप्लस 12 के साथ फ्लैगशिप प्रदर्शन और शानदार डिज़ाइन का अनुभव करें। सुपर-फास्ट स्नैपड्रैगन 8 Gen 3 प्रोसेसर और 120Hz AMOLED डिस्प्ले।',
                        'short_description'      => 'वनप्लस 12 - असाधारण गति और चिकनी स्क्रीन के साथ आपका अगला स्मार्टफोन।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'OnePlus 12',
                        'description'            => 'اختبر الأداء الرائد والتصميم المذهل مع OnePlus 12. معالج Snapdragon 8 Gen 3 فائق السرعة وشاشة AMOLED بمعدل تحديث 120 هرتز.',
                        'short_description'      => 'ون بلس 12 - هاتفك الذكي التالي مع سرعة استثنائية وشاشة سلسة.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/smartphone_7.png',
                    'uploads/website-images/product/smartphone_5.png',
                    'uploads/website-images/product/smartphone_6.png',
                    'uploads/website-images/product/smartphone_4.png',
                ],
            ],
            [
                'slug'             => 'xiaomi-mi-13-ultra',
                'image'            => 'uploads/website-images/product/smartphone_8.png',
                'status'           => true,
                'product_category_id' => 1,
                'price' => 199,
                'sale_price' => 149,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Xiaomi Mi 13 Ultra',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'The ultimate photography experience with Xiaomi Mi 13 Ultra. Leica-powered quad-camera setup and an advanced AI engine.',
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Xiaomi Mi 13 Ultra',
                        'description'            => 'श्याओमी मी 13 अल्ट्रा के साथ बेहतरीन फोटोग्राफी अनुभव प्राप्त करें। लाइका-पावर्ड क्वाड-कैमरा सेटअप और उन्नत एआई इंजन।',
                        'short_description'      => 'श्याओमी का नया फ्लैगशिप कैमरा फोन - श्याओमी मी 13 अल्ट्रा।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Xiaomi Mi 13 Ultra',
                        'description'            => 'تجربة التصوير الفوتوغرافي المطلقة مع Xiaomi Mi 13 Ultra. نظام كاميرا رباعية مدعوم من لايكا ومحرك ذكاء اصطناعي متقدم.',
                        'short_description'      => 'الهاتف الذكي الرائد من شاومي - Xiaomi Mi 13 Ultra.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/smartphone_8.png',
                    'uploads/website-images/product/smartphone_2.png',
                    'uploads/website-images/product/smartphone_3.png',
                    'uploads/website-images/product/smartphone_4.png',
                ],
            ],
            
            [
                'slug'             => 'samsung-galaxy-s24',
                'image'            => 'uploads/website-images/product/smartphone_1.png',
                'status'           => true,
                'product_category_id' => 1,
                'price' => 299,
                'sale_price' => null,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Samsung Galaxy S24',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Discover the power of the Samsung Galaxy S24. Stunning design, high-speed performance, and an advanced camera for your best moments.',
                       
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Samsung Galaxy S24',
                        'description'            => 'एलिगेंस वॉच के साथ स्टाइल, परिष्कार और सटीकता का सही मिश्रण पाएँ। यह सावधानीपूर्वक तैयार की गई घड़ी किसी भी पोशाक के पूरक और आपकी व्यक्तिगत शैली को बढ़ाने के लिए डिज़ाइन की गई है। चाहे आप किसी औपचारिक कार्यक्रम में भाग ले रहे हों, कार्यालय जा रहे हों, या किसी आकस्मिक दिन का आनंद ले रहे हों, एलिगेंस वॉच आपका आदर्श साथी है।<br/><br/>
<strong>प्रीमियम डिज़ाइन:</strong> एलिगेंस वॉच में एक चिकना और कालातीत डिज़ाइन है, जिसमें पॉलिश किया हुआ स्टेनलेस स्टील केस और स्क्रैच-प्रतिरोधी नीलम क्रिस्टल फेस है। इसका मिनिमलिस्ट डायल और सुरुचिपूर्ण हाथ इसे किसी भी अवसर के लिए एक बहुमुखी एक्सेसरी बनाते हैं।<br/><br/>
<strong>बेहतरीन शिल्प कौशल:</strong> विस्तार से ध्यान देने के साथ तैयार की गई, घड़ी में एक उच्च-परिशुद्धता क्वार्ट्ज मूवमेंट है, जो सटीक समय सुनिश्चित करता है। टिकाऊ निर्माण और गुणवत्ता वाली सामग्री लंबे समय तक चलने वाले प्रदर्शन की गारंटी देती है।<br/><br/>
<strong>आरामदायक फिट:</strong> समायोज्य चमड़े का पट्टा एक आरामदायक और सुरक्षित फिट प्रदान करता है, जिससे आप पूरे दिन आसानी से घड़ी पहन सकते हैं। पट्टा आपकी व्यक्तिगत शैली से मेल खाने के लिए विभिन्न रंगों में उपलब्ध है।<br/><br/>
<strong>जल प्रतिरोधी:</strong> 50 मीटर तक के जल प्रतिरोध के साथ, एलिगेंस वॉच रोज़ाना पहनने के लिए उपयुक्त है, जिसमें हाथ धोना और हल्की छींटे शामिल हैं। यह जानकर मन की शांति का आनंद लें कि आपकी घड़ी दैनिक गतिविधियों को संभाल सकती है।<br/><br/>
<strong>बहुमुखी कार्यक्षमता:</strong> समय प्रदर्शित करने के अलावा, एलिगेंस वॉच में एक दिनांक फ़ंक्शन भी शामिल है, जो इसके सुरुचिपूर्ण डिज़ाइन में व्यावहारिकता जोड़ता है। इस विश्वसनीय सुविधा के साथ व्यवस्थित और शेड्यूल पर रहें।',
                        'short_description'      => 'सैमसंग गैलेक्सी S24 की ताकत का अनुभव करें। शानदार डिज़ाइन, हाई-स्पीड परफॉरमेंस और आपके बेहतरीन पलों के लिए बेहतरीन कैमरा।',
                       
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Samsung Galaxy S24',
                        'description'            => "و ككل و أ. فمن رضي بواجباته فله متعة عظيمة وعظيمة. ولذلك تم اختياره لأنه كان هنا.\n\nإنها مسألة متعة وليست حادثة مفيدة. من هو حكيم مع واجبات أقل فهو هنا. يكره أن يتحمل العواقب فهو لا يعلم إن كانت ستحدث أم لا.\n\nلأنه يريد ما لا يدفع الألم إلا باللذات. لا بد من إنقاذه، أو أن الآلام التي يجب أن يعاني منها تكون مفيدة. لأن من يقدمها هو هو.\n\nأما الحكيم فينتقد الأسلوب المتعب. لمن يرغب أو حتى أصغر. فقبضوا عليه ولاذوا بالفرار.",
                        'short_description'      => 'اكتشف قوة هاتف سامسونج جالاكسي S24. تصميم مذهل، وأداء فائق السرعة، وكاميرا متطورة لأجمل لحظاتك.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/smartphone_1.png',
                    'uploads/website-images/product/smartphone_2.png',
                    'uploads/website-images/product/smartphone_3.png',
                    'uploads/website-images/product/smartphone_2.png',
                ],
            ],
            
            [
                'slug'             => 'laptop-business',
                'image'            => 'uploads/website-images/product/laptop_5.png',
                'status'           => true,
                'product_category_id' => 2,
                'price'            => 546,
                'sale_price' => null,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'Business Laptop',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'A lightweight and powerful business laptop for professionals on the go.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'Business Laptop',
                        'description'       => 'गतिशील पेशेवरों के लिए हल्का और शक्तिशाली बिज़नेस लैपटॉप।',
                        'short_description' => 'चलते-फिरते काम करने के लिए एक शक्तिशाली और हल्का बिज़नेस लैपटॉप।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'Business Laptop',
                        'description'       => 'كمبيوتر محمول خفيف الوزن وعالي الأداء للمحترفين أثناء التنقل.',
                        'short_description' => 'كمبيوتر محمول مثالي لأداء الأعمال بكفاءة أثناء التنقل.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/laptop_5.png',
                    'uploads/website-images/product/laptop_2.png',
                    'uploads/website-images/product/laptop_3.png',
                    'uploads/website-images/product/laptop_2.png',
                ],
            ],
            [
                'slug'             => 'laptop-ultrabook',
                'image'            => 'uploads/website-images/product/laptop_6.png',
                'status'           => true,
                'product_category_id' => 2,
                'price'            => 1199,
                'sale_price'       => 1099,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'Ultrabook Laptop',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Slim, lightweight, and powerful. The perfect laptop for professionals and students alike.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'Ultrabook Laptop',
                        'description'       => 'पतला, हल्का और शक्तिशाली। पेशेवरों और छात्रों के लिए आदर्श।',
                        'short_description' => 'पेशेवरों और छात्रों के लिए एकदम सही पतला और हल्का लैपटॉप।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'Ultrabook Laptop',
                        'description'       => 'نحيف وخفيف الوزن وقوي. الكمبيوتر المحمول المثالي للمحترفين والطلاب.',
                        'short_description' => 'كمبيوتر محمول نحيف وخفيف الوزن ومثالي للعمل والدراسة.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/laptop_6.png',
                    'uploads/website-images/product/laptop_2.png',
                    'uploads/website-images/product/laptop_3.png',
                    'uploads/website-images/product/laptop_2.png',
                ],
            ],
            [
                'slug'             => 'aabcserv',
                'image'            => 'uploads/website-images/product/digital_product_1.png',
                'status'           => true,
                'product_category_id' => 6,
                'price' => 29,
                'sale_price' => 19,
                'type' => Product::DIGITAL_TYPE,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Aabcserv',
                        'description'            => "<p>Aabcserv – Multivendor On-Demand Service & Handyman Marketplace Flutter User App is a comprehensive solution for selling and finding on-demand services. It boasts a well-crafted design and development that offers maximum features in the market. This platform is suitable for any business or service seller dealing with services such as AC repair, car repair, plumbing, home cleaning, cleaning services, or any other service available in the market based on demand.</p><p>Aabcserv – Multivendor On-Demand Service & Handyman Marketplace Flutter App is built using the latest Flutter technology, ensuring top-notch security with no possibility of SQL injection, XSS attacks, or CSRF attacks. Additionally, the platform offers an extensive range of features tailored to meet the unique requirements of users or sellers.</p>",
                        'short_description'      => 'Step into style and comfort with our Urban Sneakers. Designed for versatility, they effortlessly complement your casual and active lifestyles.',
                        
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Aabcserv',
                        'description'            => "<p>Aabcserv – मल्टीवेंडर ऑन-डिमांड सर्विस और हैंडीमैन मार्केटप्लेस फ़्लटर यूजर ऐप ऑन-डिमांड सेवाओं को बेचने और खोजने के लिए एक व्यापक समाधान है। यह एक अच्छी तरह से तैयार की गई डिज़ाइन और विकास का दावा करता है जो बाजार में अधिकतम सुविधाएँ प्रदान करता है। यह प्लेटफ़ॉर्म किसी भी व्यवसाय या सेवा विक्रेता के लिए उपयुक्त है जो एसी मरम्मत, कार मरम्मत, प्लंबिंग, घर की सफाई, सफाई सेवाएँ, या मांग के आधार पर बाजार में उपलब्ध किसी भी अन्य सेवा से संबंधित है।</p><p>Aabcserv – मल्टीवेंडर ऑन-डिमांड सर्विस और हैंडीमैन मार्केटप्लेस फ़्लटर ऐप नवीनतम फ़्लटर तकनीक का उपयोग करके बनाया गया है, जो SQL इंजेक्शन, XSS हमलों या CSRF हमलों की कोई संभावना नहीं होने के साथ शीर्ष पायदान सुरक्षा सुनिश्चित करता है। इसके अतिरिक्त, प्लेटफ़ॉर्म उपयोगकर्ताओं या विक्रेताओं की अनूठी आवश्यकताओं को पूरा करने के लिए तैयार की गई सुविधाओं की एक विस्तृत श्रृंखला प्रदान करता है।</p>",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Aabcserv',
                        'description'            => "<p>Aabcserv - تطبيق Flutter User هو حل شامل لبيع وإيجاد الخدمات عند الطلب. يتميز بتصميم وتطوير متقنين يوفران أفضل الميزات المتوفرة في السوق. هذه المنصة مناسبة لأي شركة أو بائع خدمات يتعامل مع خدمات مثل إصلاح مكيفات الهواء، وإصلاح السيارات، والسباكة، وتنظيف المنازل، وخدمات التنظيف، أو أي خدمة أخرى متوفرة في السوق حسب الطلب.</p><p>تطبيق Aabcserv - خدمة متعددة الموردين حسب الطلب وسوق للعمالة اليدوية، Flutter مصمم باستخدام أحدث تقنيات Flutter، مما يضمن أمانًا فائقًا دون أي احتمال لهجمات حقن SQL أو XSS أو CSRF. بالإضافة إلى ذلك، توفر المنصة مجموعة واسعة من الميزات المصممة خصيصًا لتلبية الاحتياجات الفريدة للمستخدمين والبائعين.</p>",
                        'short_description'      => 'احصل على الأناقة والراحة مع أحذية Urban الرياضية الخاصة بنا. مصممة لتعدد الاستخدامات، فهي تكمل أنماط حياتك غير الرسمية والنشيطة دون عناء.',
                    ],
                ],
                'extra_image'      => [

                    'uploads/website-images/product/digital_product_1.png',
                    'uploads/website-images/product/digital_product_2.png',
                    'uploads/website-images/product/digital_product_3.png',
                    'uploads/website-images/product/digital_product_4.png',
                    'uploads/website-images/product/digital_product_5.png',
                    'uploads/website-images/product/digital_product_2.png',
                ],
            ],
            [
                'slug'             => 'findestate',
                'image'            => 'uploads/website-images/product/digital_product_3.png',
                'status'           => true,
                'product_category_id' => 6,
                'price' => 59, 
                'sale_price' => 49, 
                'type' => Product::DIGITAL_TYPE,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'FindEstate',
                        'description'            => "<p>FindEstate is a real estate management Laravel script. Here users or agents can publish their real estate listing based on some pricing plans and visitors can easily contact with the real estate agent to buy or sell properties.</p><p>This is mainly a listing website to build connection between buyers and sellers; and you will get the SaaS version completely free in regular license.</p>",
                        'short_description'      => 'Step into style and comfort with our Urban Sneakers. Designed for versatility, they effortlessly complement your casual and active lifestyles.',
                        
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'FindEstate',
                        'description'            => "<p>FindEstate एक रियल एस्टेट मैनेजमेंट Laravel स्क्रिप्ट है। यहाँ उपयोगकर्ता या एजेंट कुछ मूल्य निर्धारण योजनाओं के आधार पर अपनी रियल एस्टेट लिस्टिंग प्रकाशित कर सकते हैं और आगंतुक आसानी से संपत्ति खरीदने या बेचने के लिए रियल एस्टेट एजेंट से संपर्क कर सकते हैं।</p><p>यह मुख्य रूप से खरीदारों और विक्रेताओं के बीच संबंध बनाने के लिए एक लिस्टिंग वेबसाइट है; और आपको SaaS संस्करण नियमित लाइसेंस में पूरी तरह से मुफ़्त मिलेगा।</p>",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'FindEstate',
                        'description'            => "<p>TopCommerce - تطبيق Flutter User هو حل شامل لبيع وإيجاد الخدمات عند الطلب. يتميز بتصميم وتطوير متقنين يوفران أفضل الميزات المتوفرة في السوق. هذه المنصة مناسبة لأي شركة أو بائع خدمات يتعامل مع خدمات مثل إصلاح مكيفات الهواء، وإصلاح السيارات، والسباكة، وتنظيف المنازل، وخدمات التنظيف، أو أي خدمة أخرى متوفرة في السوق حسب الطلب.</p><p>تطبيق TopCommerce - خدمة متعددة الموردين حسب الطلب وسوق للعمالة اليدوية، Flutter مصمم باستخدام أحدث تقنيات Flutter، مما يضمن أمانًا فائقًا دون أي احتمال لهجمات حقن SQL أو XSS أو CSRF. بالإضافة إلى ذلك، توفر المنصة مجموعة واسعة من الميزات المصممة خصيصًا لتلبية الاحتياجات الفريدة للمستخدمين والبائعين.</p>",
                        'short_description'      => 'احصل على الأناقة والراحة مع أحذية Urban الرياضية الخاصة بنا. مصممة لتعدد الاستخدامات، فهي تكمل أنماط حياتك غير الرسمية والنشيطة دون عناء.',
                    ],
                ],
                'extra_image'      => [

                    'uploads/website-images/product/digital_product_3.png',
                    'uploads/website-images/product/digital_product_1.png',
                    'uploads/website-images/product/digital_product_4.png',
                    'uploads/website-images/product/digital_product_1.png',
                    'uploads/website-images/product/digital_product_2.png',
                ],
            ],
            [
                'slug'             => 'laptop-2in1',
                'image'            => 'uploads/website-images/product/laptop_2.png',
                'status'           => true,
                'product_category_id' => 2,
                'price'       => 999,
                'sale_price' => null,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => '2-in-1 Convertible Laptop',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Switch between laptop and tablet mode seamlessly with this powerful 2-in-1 device.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => '2-in-1 Convertible Laptop',
                        'description'       => 'इस शक्तिशाली 2-इन-1 डिवाइस के साथ लैपटॉप और टैबलेट मोड के बीच आसानी से स्विच करें।',
                        'short_description' => 'लैपटॉप और टैबलेट मोड के बीच आसानी से स्विच करें।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => '2-in-1 Convertible Laptop',
                        'description'       => 'بدّل بين وضع الكمبيوتر المحمول والجهاز اللوحي بسلاسة مع هذا الجهاز القوي 2 في 1.',
                        'short_description' => 'جهاز قوي 2 في 1 يوفر تجربة الكمبيوتر المحمول والجهاز اللوحي في جهاز واحد.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/laptop_2.png',
                    'uploads/website-images/product/laptop_5.png',
                    'uploads/website-images/product/laptop_3.png',
                    'uploads/website-images/product/laptop_5.png',
                ],
            ],
            [
                'slug'             => 'ultraslim-power-bank',
                'image'            => 'uploads/website-images/product/power_bank_1.png',
                'status'           => true,
                'product_category_id' => 3,
                'price'            => 19,
                'sale_price'       => null,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'UltraSlim Power Bank',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Stay charged on the go with our UltraSlim Power Bank. Compact yet powerful, it keeps your devices fueled for all your adventures.',
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'UltraSlim Power Bank',
                        'description'            => 'कहीं भी रहें, हमारे अल्ट्रास्लिम पावर बैंक के साथ अपने डिवाइस को चार्ज रखें। इसकी उच्च क्षमता और तेज़ चार्जिंग तकनीक इसे यात्रा के लिए आदर्श बनाती है।',
                        'short_description'      => 'छोटा लेकिन शक्तिशाली, यह पावर बैंक आपकी सभी ज़रूरतों को पूरा करता है।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'UltraSlim Power Bank',
                        'description'            => 'ابق مشحونًا أثناء التنقل مع بنك الطاقة النحيف للغاية. تصميمه المدمج وقوته العالية تجعله الخيار الأمثل لرحلاتك اليومية.',
                        'short_description'      => 'تصميم أنيق وشحن سريع لجميع أجهزتك المحمولة.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/power_bank_1.png',
                    'uploads/website-images/product/power_bank_3.png',
                    'uploads/website-images/product/power_bank_2.png',
                    'uploads/website-images/product/power_bank_3.png',
                ],
            ],
            [
                'slug'             => 'recliner-sofa',
                'image'            => 'uploads/website-images/product/chair_6.png',
                'status'           => true,
                'product_category_id' => 4,
                'price'            => 399,
                'sale_price'       => 349,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'Recliner Sofa',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Relax in luxury with our recliner sofa, offering plush comfort and a modern look.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'Recliner Sofa',
                        'description'       => 'प्रीमियम आराम और स्टाइल के लिए डिज़ाइन किया गया, हमारा रीक्लाइनर सोफा आपके घर के लिए एक उत्तम जोड़ है।',
                        'short_description' => 'आरामदायक और स्टाइलिश, यह सोफा आपके लिविंग रूम को एक नया रूप देगा।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'Recliner Sofa',
                        'description'       => 'استمتع بالراحة والفخامة مع كنبة الاسترخاء لدينا، بتصميم حديث وراحة فائقة.',
                        'short_description' => 'اجعل منزلك أكثر راحة مع كنبة الاسترخاء الفاخرة ذات التصميم الحديث.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/chair_6.png',
                    'uploads/website-images/product/chair_2.png',
                    'uploads/website-images/product/chair_3.png',
                    'uploads/website-images/product/chair_4.png',
                ],
            ],
            [
                'slug'             => 'iphone',
                'image'            => 'uploads/website-images/product/smartphone_4.png',
                'status'           => true,
                'product_category_id' => 1,
                'price' => 240,
                'sale_price' => null,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Iphone',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Experience innovation with the latest iPhone. A sleek design, powerful performance, and an advanced camera for every moment.',
                       
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Iphone',
                        'description'            => 'एलिगेंस वॉच के साथ स्टाइल, परिष्कार और सटीकता का सही मिश्रण पाएँ। यह सावधानीपूर्वक तैयार की गई घड़ी किसी भी पोशाक के पूरक और आपकी व्यक्तिगत शैली को बढ़ाने के लिए डिज़ाइन की गई है। चाहे आप किसी औपचारिक कार्यक्रम में भाग ले रहे हों, कार्यालय जा रहे हों, या किसी आकस्मिक दिन का आनंद ले रहे हों, एलिगेंस वॉच आपका आदर्श साथी है।<br/><br/>
<strong>प्रीमियम डिज़ाइन:</strong> एलिगेंस वॉच में एक चिकना और कालातीत डिज़ाइन है, जिसमें पॉलिश किया हुआ स्टेनलेस स्टील केस और स्क्रैच-प्रतिरोधी नीलम क्रिस्टल फेस है। इसका मिनिमलिस्ट डायल और सुरुचिपूर्ण हाथ इसे किसी भी अवसर के लिए एक बहुमुखी एक्सेसरी बनाते हैं।<br/><br/>
<strong>बेहतरीन शिल्प कौशल:</strong> विस्तार से ध्यान देने के साथ तैयार की गई, घड़ी में एक उच्च-परिशुद्धता क्वार्ट्ज मूवमेंट है, जो सटीक समय सुनिश्चित करता है। टिकाऊ निर्माण और गुणवत्ता वाली सामग्री लंबे समय तक चलने वाले प्रदर्शन की गारंटी देती है।<br/><br/>
<strong>आरामदायक फिट:</strong> समायोज्य चमड़े का पट्टा एक आरामदायक और सुरक्षित फिट प्रदान करता है, जिससे आप पूरे दिन आसानी से घड़ी पहन सकते हैं। पट्टा आपकी व्यक्तिगत शैली से मेल खाने के लिए विभिन्न रंगों में उपलब्ध है।<br/><br/>
<strong>जल प्रतिरोधी:</strong> 50 मीटर तक के जल प्रतिरोध के साथ, एलिगेंस वॉच रोज़ाना पहनने के लिए उपयुक्त है, जिसमें हाथ धोना और हल्की छींटे शामिल हैं। यह जानकर मन की शांति का आनंद लें कि आपकी घड़ी दैनिक गतिविधियों को संभाल सकती है।<br/><br/>
<strong>बहुमुखी कार्यक्षमता:</strong> समय प्रदर्शित करने के अलावा, एलिगेंस वॉच में एक दिनांक फ़ंक्शन भी शामिल है, जो इसके सुरुचिपूर्ण डिज़ाइन में व्यावहारिकता जोड़ता है। इस विश्वसनीय सुविधा के साथ व्यवस्थित और शेड्यूल पर रहें।',
                        'short_description'      => 'नवीनतम iPhone के साथ नवाचार का अनुभव करें। एक आकर्षक डिज़ाइन, शक्तिशाली प्रदर्शन, और हर पल के लिए एक उन्नत कैमरा।',
                       
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Iphone',
                        'description'            => "و ككل و أ. فمن رضي بواجباته فله متعة عظيمة وعظيمة. ولذلك تم اختياره لأنه كان هنا.\n\nإنها مسألة متعة وليست حادثة مفيدة. من هو حكيم مع واجبات أقل فهو هنا. يكره أن يتحمل العواقب فهو لا يعلم إن كانت ستحدث أم لا.\n\nلأنه يريد ما لا يدفع الألم إلا باللذات. لا بد من إنقاذه، أو أن الآلام التي يجب أن يعاني منها تكون مفيدة. لأن من يقدمها هو هو.\n\nأما الحكيم فينتقد الأسلوب المتعب. لمن يرغب أو حتى أصغر. فقبضوا عليه ولاذوا بالفرار.",
                        'short_description'      => 'استمتع بتجربة ابتكارية مع أحدث هواتف iPhone. تصميم أنيق، وأداء قوي، وكاميرا متطورة لكل لحظة.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/smartphone_4.png',
                    'uploads/website-images/product/smartphone_5.png',
                    'uploads/website-images/product/smartphone_6.png',
                    'uploads/website-images/product/smartphone_5.png',
                ],
            ],
            [
                'slug'             => 'laptop-gaming',
                'image'            => 'uploads/website-images/product/laptop_1.png',
                'status'           => true,
                'product_category_id' => 2,
                'price'            => 799,
                'sale_price'       => 699,
                'translations'     => [
                    [
                        'lang_code'         => 'en',
                        'title'             => 'Gaming Laptop',
                        'description'       => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description' => 'Experience ultimate gaming with our high-performance gaming laptop, featuring top-tier graphics and processing power.',
                    ],
                    [
                        'lang_code'         => 'hi',
                        'title'             => 'Gaming Laptop',
                        'description'       => 'शक्तिशाली गेमिंग प्रदर्शन और उच्च गुणवत्ता वाले ग्राफिक्स के साथ हमारे गेमिंग लैपटॉप का अनुभव करें।',
                        'short_description' => 'बेहतरीन ग्राफिक्स और प्रोसेसिंग पावर के साथ अल्टीमेट गेमिंग का अनुभव लें।',
                    ],
                    [
                        'lang_code'         => 'ar',
                        'title'             => 'Gaming Laptop',
                        'description'       => 'استمتع بأفضل تجربة ألعاب مع كمبيوتر محمول قوي يتميز برسومات عالية الجودة وأداء استثنائي.',
                        'short_description' => 'استمتع بأداء ألعاب قوي مع هذا الكمبيوتر المحمول المصمم للألعاب عالية الأداء.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/laptop_1.png',
                    'uploads/website-images/product/laptop_2.png',
                    'uploads/website-images/product/laptop_3.png',
                    'uploads/website-images/product/laptop_2.png',
                ],
            ],
            [
                'slug'             => 'modern-lounge-chair',
                'image'            => 'uploads/website-images/product/chair_5.png',
                'status'           => true,
                'product_category_id' => 4,
                'price'            => 120,
                'sale_price'       => 99,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Modern Lounge Chair',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Upgrade your space with our Modern Lounge Chair, designed for relaxation and sophistication. Its ergonomic shape and plush cushioning provide superior comfort.',
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Modern Lounge Chair',
                        'description'            => 'हमारी आधुनिक लाउंज कुर्सी के साथ अपने रहने की जगह को अपग्रेड करें। इसका एर्गोनॉमिक आकार और मुलायम कुशनिंग बेहतरीन आराम प्रदान करते हैं।',
                        'short_description'      => 'आराम और स्टाइल के लिए आधुनिक डिज़ाइन वाली कुर्सी।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Modern Lounge Chair',
                        'description'            => 'قم بترقية مساحتك باستخدام كرسي الاسترخاء العصري الخاص بنا، المصمم للاسترخاء والأناقة. يوفر شكله المريح وتنجيده الناعم راحة فائقة.',
                        'short_description'      => 'كرسي عصري مصمم للاسترخاء والراحة القصوى.',
                    ],
                ],
                'extra_image'      => [
                    'uploads/website-images/product/chair_5.png',
                    'uploads/website-images/product/chair_3.png',
                    'uploads/website-images/product/chair_4.png',
                    'uploads/website-images/product/chair_2.png',
                ],
            ],
            [
                'slug'             => 'shoe',
                'image'            => 'uploads/website-images/product/shoes_1.png',
                'status'           => true,
                'product_category_id' => 5,
                'price' => 32,
                'sale_price' => 24,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'Shoe',
                        'description'            => nl2br(implode("\n\n", $faker->paragraphs(4))),
                        'short_description'      => 'Step into style and comfort with our Urban Sneakers. Designed for versatility, they effortlessly complement your casual and active lifestyles.',
                        
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'Shoe',
                        'description'            => "एलिगेंस वॉच के साथ स्टाइल, परिष्कार और सटीकता का सही मिश्रण पाएँ। यह सावधानीपूर्वक तैयार की गई घड़ी किसी भी पोशाक के पूरक और आपकी व्यक्तिगत शैली को बढ़ाने के लिए डिज़ाइन की गई है। चाहे आप किसी औपचारिक कार्यक्रम में भाग ले रहे हों, कार्यालय जा रहे हों, या किसी आकस्मिक दिन का आनंद ले रहे हों, एलिगेंस वॉच आपका आदर्श साथी है।<br/><br/>
<strong>प्रीमियम डिज़ाइन:</strong> एलिगेंस वॉच में एक चिकना और कालातीत डिज़ाइन है, जिसमें पॉलिश किया हुआ स्टेनलेस स्टील केस और स्क्रैच-प्रतिरोधी नीलम क्रिस्टल फेस है। इसका मिनिमलिस्ट डायल और सुरुचिपूर्ण हाथ इसे किसी भी अवसर के लिए एक बहुमुखी एक्सेसरी बनाते हैं।<br/><br/>
<strong>बेहतरीन शिल्प कौशल:</strong> विस्तार से ध्यान देने के साथ तैयार की गई, घड़ी में एक उच्च-परिशुद्धता क्वार्ट्ज मूवमेंट है, जो सटीक समय सुनिश्चित करता है। टिकाऊ निर्माण और गुणवत्ता वाली सामग्री लंबे समय तक चलने वाले प्रदर्शन की गारंटी देती है।<br/><br/>
<strong>आरामदायक फिट:</strong> समायोज्य चमड़े का पट्टा एक आरामदायक और सुरक्षित फिट प्रदान करता है, जिससे आप पूरे दिन आसानी से घड़ी पहन सकते हैं। पट्टा आपकी व्यक्तिगत शैली से मेल खाने के लिए विभिन्न रंगों में उपलब्ध है।<br/><br/>
<strong>जल प्रतिरोधी:</strong> 50 मीटर तक के जल प्रतिरोध के साथ, एलिगेंस वॉच रोज़ाना पहनने के लिए उपयुक्त है, जिसमें हाथ धोना और हल्की छींटे शामिल हैं। यह जानकर मन की शांति का आनंद लें कि आपकी घड़ी दैनिक गतिविधियों को संभाल सकती है।<br/><br/>
<strong>बहुमुखी कार्यक्षमता:</strong> समय प्रदर्शित करने के अलावा, एलिगेंस वॉच में एक दिनांक फ़ंक्शन भी शामिल है, जो इसके सुरुचिपूर्ण डिज़ाइन में व्यावहारिकता जोड़ता है। इस विश्वसनीय सुविधा के साथ व्यवस्थित और शेड्यूल पर रहें।",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'Shoe',
                        'description'            => "و ككل و أ. فمن رضي بواجباته فله متعة عظيمة وعظيمة. ولذلك تم اختياره لأنه كان هنا.\n\nإنها مسألة متعة وليست حادثة مفيدة. من هو حكيم مع واجبات أقل فهو هنا. يكره أن يتحمل العواقب فهو لا يعلم إن كانت ستحدث أم لا.\n\nلأنه يريد ما لا يدفع الألم إلا باللذات. لا بد من إنقاذه، أو أن الآلام التي يجب أن يعاني منها تكون مفيدة. لأن من يقدمها هو هو.\n\nأما الحكيم فينتقد الأسلوب المتعب. لمن يرغب أو حتى أصغر. فقبضوا عليه ولاذوا بالفرار.",
                        'short_description'      => 'احصل على الأناقة والراحة مع أحذية Urban الرياضية الخاصة بنا. مصممة لتعدد الاستخدامات، فهي تكمل أنماط حياتك غير الرسمية والنشيطة دون عناء.',
                    ],
                ],
                'extra_image'      => [

                    'uploads/website-images/product/shoes_1.png',
                    'uploads/website-images/product/shoes_2.png',
                    'uploads/website-images/product/shoes_3.png',
                    'uploads/website-images/product/shoes_2.png',
                ],
            ],
            [
                'slug'             => 'dirList',
                'image'            => 'uploads/website-images/product/digital_product_2.png',
                'status'           => true,
                'product_category_id' => 6,
                'price' => 34,
                'sale_price' => null, 
                'type' => Product::DIGITAL_TYPE,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'DirList',
                        'description'            => "<p>DirList is a SaaS Based Listing Directory CMS. In this software, users can do free registration, buy or enroll package and add their own listing. This web application is suitable for any listing, real estate, hotel, booking, restaurant, travel, cars etc. that has listing features. Admin or the website owner can earn money easily creating packages for the users.</p><p>This system was made using the popular Laravel php framework. Strong security was maintained during the development and there is no sql injection, xss attack, csrf attack possible.</p>",
                        'short_description'      => 'Step into style and comfort with our Urban Sneakers. Designed for versatility, they effortlessly complement your casual and active lifestyles.',
                        
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'DirList',
                        'description'            => "<p>DirList एक SaaS आधारित लिस्टिंग डायरेक्टरी CMS है। इस सॉफ़्टवेयर में, उपयोगकर्ता निःशुल्क पंजीकरण कर सकते हैं, पैकेज खरीद या नामांकित कर सकते हैं और अपनी खुद की लिस्टिंग जोड़ सकते हैं। यह वेब एप्लिकेशन किसी भी लिस्टिंग, रियल एस्टेट, होटल, बुकिंग, रेस्तरां, यात्रा, कार आदि के लिए उपयुक्त है जिसमें लिस्टिंग सुविधाएँ हैं। व्यवस्थापक या वेबसाइट स्वामी उपयोगकर्ताओं के लिए पैकेज बनाकर आसानी से पैसे कमा सकते हैं।</p><p>यह सिस्टम लोकप्रिय Laravel php फ्रेमवर्क का उपयोग करके बनाया गया था। विकास के दौरान मजबूत सुरक्षा बनाए रखी गई थी और कोई SQL इंजेक्शन, XSS हमला, CSRF हमला संभव नहीं है।</p>",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'DirList',
                        'description'            => "<p>DirList - تطبيق Flutter User هو حل شامل لبيع وإيجاد الخدمات عند الطلب. يتميز بتصميم وتطوير متقنين يوفران أفضل الميزات المتوفرة في السوق. هذه المنصة مناسبة لأي شركة أو بائع خدمات يتعامل مع خدمات مثل إصلاح مكيفات الهواء، وإصلاح السيارات، والسباكة، وتنظيف المنازل، وخدمات التنظيف، أو أي خدمة أخرى متوفرة في السوق حسب الطلب.</p><p>تطبيق DirList - خدمة متعددة الموردين حسب الطلب وسوق للعمالة اليدوية، Flutter مصمم باستخدام أحدث تقنيات Flutter، مما يضمن أمانًا فائقًا دون أي احتمال لهجمات حقن SQL أو XSS أو CSRF. بالإضافة إلى ذلك، توفر المنصة مجموعة واسعة من الميزات المصممة خصيصًا لتلبية الاحتياجات الفريدة للمستخدمين والبائعين.</p>",
                        'short_description'      => 'احصل على الأناقة والراحة مع أحذية Urban الرياضية الخاصة بنا. مصممة لتعدد الاستخدامات، فهي تكمل أنماط حياتك غير الرسمية والنشيطة دون عناء.',
                    ],
                ],
                'extra_image'      => [

                    'uploads/website-images/product/digital_product_2.png',
                    'uploads/website-images/product/digital_product_4.png',
                    'uploads/website-images/product/digital_product_3.png',
                    'uploads/website-images/product/digital_product_5.png',
                    'uploads/website-images/product/digital_product_4.png',
                ],
            ],
            [
                'slug'             => 'topcommerce',
                'image'            => 'uploads/website-images/product/digital_product_4.png',
                'status'           => true,
                'product_category_id' => 6,
                'price' => 49,
                'sale_price' => null, 
                'type' => Product::DIGITAL_TYPE,
                'translations'     => [
                    [
                        'lang_code'              => 'en',
                        'title'                  => 'TopCommerce',
                        'description'            => "<p>Are you looking for a complete Multivendor Shopping Ecommerce solution system for your business, then you are in the right place. TopCommerce – is a Multi Vendor eCommerce Shopping Platform. You can choose TopCommerce script as the most suitable platform for multi-vendor eCommerce.</p><p>You can use it for : Toys & Kids Shop, Beauty & Health Shop, Watch & Jewelry Shop, Man & Women Fashion Shop, Electronics & Computers Shop, Food & Grocery Shop, Tools & Parts Shop, Home & Furniture Shop, Sports & Outdoors Shop, etc.</p><p>eCommerce platforms are gaining more and more popularity nowadays and we keep maintaining all the demands of our users. The script has unlimited category, brands, products, attributes. coupons, orders, category create options. It comes with 9 payment gateways, full content management system, SEO, order tracking system, and more</p>",
                        'short_description'      => 'Step into style and comfort with our Urban Sneakers. Designed for versatility, they effortlessly complement your casual and active lifestyles.',
                        
                    ],
                    [
                        'lang_code'              => 'hi',
                        'title'                  => 'TopCommerce',
                        'description'            => "<p>क्या आप अपने व्यवसाय के लिए एक संपूर्ण मल्टीवेंडर शॉपिंग ईकॉमर्स समाधान प्रणाली की तलाश कर रहे हैं, तो आप सही जगह पर हैं। TopCommerce - एक मल्टी वेंडर ईकॉमर्स शॉपिंग प्लेटफ़ॉर्म है। आप मल्टी-वेंडर ईकॉमर्स के लिए सबसे उपयुक्त प्लेटफ़ॉर्म के रूप में TopCommerce स्क्रिप्ट चुन सकते हैं।</p><p>आप इसका उपयोग निम्न के लिए कर सकते हैं: खिलौने और बच्चों की दुकान, सौंदर्य और स्वास्थ्य की दुकान, घड़ी और आभूषण की दुकान, पुरुषों और महिलाओं के फैशन की दुकान, इलेक्ट्रॉनिक्स और कंप्यूटर की दुकान, खाद्य और किराने की दुकान, उपकरण और पार्ट्स की दुकान, घर और फर्नीचर की दुकान, खेल और आउटडोर की दुकान, आदि।</p><p>ईकॉमर्स प्लेटफ़ॉर्म आजकल बहुत अधिक लोकप्रिय हो रहे हैं और हम अपने उपयोगकर्ताओं की सभी मांगों को पूरा करते रहते हैं। स्क्रिप्ट में असीमित श्रेणी, ब्रांड, उत्पाद, विशेषताएँ, कूपन, ऑर्डर, श्रेणी बनाने के विकल्प हैं। यह 9 भुगतान गेटवे, पूर्ण सामग्री प्रबंधन प्रणाली, SEO, ऑर्डर ट्रैकिंग सिस्टम और बहुत कुछ के साथ आता है</p>",
                        'short_description'      => 'हमारे अर्बन स्नीकर्स के साथ स्टाइल और आराम का अनुभव लें। बहुमुखी प्रतिभा के लिए डिज़ाइन किए गए, वे आसानी से आपकी कैज़ुअल और सक्रिय जीवनशैली को पूरा करते हैं।',
                    ],
                    [
                        'lang_code'              => 'ar',
                        'title'                  => 'TopCommerce',
                        'description'            => "<p>TopCommerce - تطبيق Flutter User هو حل شامل لبيع وإيجاد الخدمات عند الطلب. يتميز بتصميم وتطوير متقنين يوفران أفضل الميزات المتوفرة في السوق. هذه المنصة مناسبة لأي شركة أو بائع خدمات يتعامل مع خدمات مثل إصلاح مكيفات الهواء، وإصلاح السيارات، والسباكة، وتنظيف المنازل، وخدمات التنظيف، أو أي خدمة أخرى متوفرة في السوق حسب الطلب.</p><p>تطبيق TopCommerce - خدمة متعددة الموردين حسب الطلب وسوق للعمالة اليدوية، Flutter مصمم باستخدام أحدث تقنيات Flutter، مما يضمن أمانًا فائقًا دون أي احتمال لهجمات حقن SQL أو XSS أو CSRF. بالإضافة إلى ذلك، توفر المنصة مجموعة واسعة من الميزات المصممة خصيصًا لتلبية الاحتياجات الفريدة للمستخدمين والبائعين.</p>",
                        'short_description'      => 'احصل على الأناقة والراحة مع أحذية Urban الرياضية الخاصة بنا. مصممة لتعدد الاستخدامات، فهي تكمل أنماط حياتك غير الرسمية والنشيطة دون عناء.',
                    ],
                ],
                'extra_image'      => [

                    'uploads/website-images/product/digital_product_4.png',
                    'uploads/website-images/product/digital_product_5.png',
                    'uploads/website-images/product/digital_product_1.png',
                    'uploads/website-images/product/digital_product_2.png',
                    'uploads/website-images/product/digital_product_5.png',
                ],
            ],
        ];
        $admin_id = Admin::first()->id;
        $additional_description = "<table class='woocommerce-table'>
                    <tbody>
                        <tr>
                            <th>Brand</th>
                            <td>Jakuna</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td>Yellow</td>
                        </tr>
                    </tbody>
                </table>";

        $digital_additional_description = "<table class='woocommerce-table'>
                    <tbody>
                        <tr>
                            <th>High resolution</th>
                            <td>Cross browser</td>
                        </tr>
                        <tr>
                            <th>Yes</th>
                            <td>Yes</td>
                        </tr>
                    </tbody>
                </table>";

        $users = User::select(['id','email','name'])->get();

        foreach ($dummyProducts as $value) {
            $product = new Product();
            $product->admin_id = $admin_id;
            $product->product_category_id = $value['product_category_id'];
            $product->slug = $value['slug'];
            $product->image = $value['image'];
            $product->views = $faker->numberBetween(0, 100000);
            $product->is_popular = $faker->boolean;
            $product->is_new = $faker->boolean;
            $tags = $faker->words(3);

            if(isset($value['type'])){
                $product->type = $value['type'];
                $product->file_path = 'public/products/script.zip';
            }

            do {
                $sku = strtoupper(Str::random(8));
            } while (Product::where('sku', $sku)->exists());

            $product->sku = $sku;
            $product->qty = $faker->numberBetween(1, 20);

            $product->price = $value['price'];
            $product->sale_price = $value['sale_price'];

            $tagObjects = array_map(function ($tag) {
                return ['value' => $tag];
            }, $tags);
            $product->tags = json_encode($tagObjects);
            $product->status = $value['status'];
            $product->created_at = $faker->dateTimeBetween('-1 year', 'now');

            $product->save();

            foreach ($value['translations'] as $data) {
                $productTranslation = new ProductTranslation();
                $productTranslation->product_id = $product->id;
                $productTranslation->lang_code = $data['lang_code'];
                $productTranslation->title = $data['title'];
                $productTranslation->short_description = $data['short_description'];
                $productTranslation->description = $data['description'];
                $productTranslation->seo_title = $data['title'];
                $productTranslation->seo_description = $data['short_description'];
                if(isset($value['type'])){
                    $productTranslation->additional_description = $digital_additional_description;
                }else{
                    $productTranslation->additional_description = $additional_description;
                }
                $productTranslation->save();
            }

            foreach ($value['extra_image'] as $extra_image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'preview'    => $extra_image,
                    'image'      => $extra_image,
                ]);
            }

            foreach ($users as $user) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id'    => $user->id,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'review'     => $faker->paragraph,
                    'rating'     => 5,
                    'admin_id'   => $admin_id,
                    'status'     => $faker->boolean,
                ]);
            }
        }
        //favourite product seeders added
        $products = Product::inRandomOrder()->take(8)->pluck('id');
        $user = $users->where('email','user@gmail.com')->first();
        $user->favoriteProducts()->attach($products);
    }
}
