<?php

namespace App\Traits;

use ReflectionClass;

trait PermissionsTrait
{
    public static array $dashboardPermissions = [
        'group_name' => 'dashboard',
        'permissions' => [
            'dashboard.view',
        ],
    ];

    public static array $adminProfilePermissions = [
        'group_name' => 'admin profile',
        'permissions' => [
            'admin.profile.view',
            'admin.profile.update',
        ],
    ];
    public static array $brandPermission = [
        'group_name' => 'brand management',
        'permissions' => [
            'brand.management',
        ],
    ];
    public static array $ourTeamPermissions = [
        'group_name' => 'our team',
        'permissions' => [
            'team.management',
        ],
    ];
    public static array $awardPermissions = [
        'group_name' => 'marquee',
        'permissions' => [
            'award.view',
            'award.management',
        ],
    ];
    public static array $countryPermissions = [
        'group_name' => 'country',
        'permissions' => [
            'country.view',
            'country.management',
        ],
    ];
    public static array $marqueePermissions = [
        'group_name' => 'marquee',
        'permissions' => [
            'marquee.view',
            'marquee.management',
        ],
    ];
    public static array $servicePermissions = [
        'group_name' => 'service',
        'permissions' => [
            'service.view',
            'service.management',
        ],
    ];
    public static array $projectPermissions = [
        'group_name' => 'project',
        'permissions' => [
            'project.view',
            'project.management',
        ],
    ];
    public static array $couponManagementPermissions = [
        'group_name' => 'coupon management',
        'permissions' => [
            'coupon.management',
        ],
    ];
    public static array $orderManagementPermissions = [
        'group_name' => 'order management',
        'permissions' => [
            'order.management',
        ],
    ];
    public static array $shippingPermissions = [
        'group_name' => 'shipping method',
        'permissions' => [
            'shipping.method.view',
            'shipping.method.management',
        ],
    ];
    public static array $refundManagementPermissions = [
        'group_name' => 'refund management',
        'permissions' => [
            'refund.management',
        ],
    ];
    public static array $shopPermissions = [
        'group_name' => 'shop',
        'permissions' => [
            'product.category.management',
            'product.management',
            'product.review.management',
        ],
    ];

    public static array $adminPermissions = [
        'group_name' => 'admin',
        'permissions' => [
            'admin.view',
            'admin.create',
            'admin.store',
            'admin.edit',
            'admin.update',
            'admin.delete',
        ],
    ];

    public static array $blogCatgoryPermissions = [
        'group_name' => 'blog category',
        'permissions' => [
            'blog.category.view',
            'blog.category.create',
            'blog.category.translate',
            'blog.category.store',
            'blog.category.edit',
            'blog.category.update',
            'blog.category.delete',
        ],
    ];

    public static array $blogPermissions = [
        'group_name' => 'blog',
        'permissions' => [
            'blog.view',
            'blog.create',
            'blog.translate',
            'blog.store',
            'blog.edit',
            'blog.update',
            'blog.delete',
        ],
    ];

    public static array $blogCommentPermissions = [
        'group_name' => 'blog comment',
        'permissions' => [
            'blog.comment.view',
            'blog.comment.update',
            'blog.comment.replay',
            'blog.comment.delete',
        ],
    ];

    public static array $rolePermissions = [
        'group_name' => 'role',
        'permissions' => [
            'role.view',
            'role.create',
            'role.store',
            'role.assign',
            'role.edit',
            'role.update',
            'role.delete',
        ],
    ];

    public static array $settingPermissions = [
        'group_name' => 'setting',
        'permissions' => [
            'setting.view',
            'setting.update',
        ],
    ];
    public static array $footerPermission = [
        'group_name' => 'footer management',
        'permissions' => [
            'footer.management',
        ],
    ];
    public static array $appearancePermission = [
        'group_name' => 'site appearance management',
        'permissions' => [
            'appearance.management',
        ],
    ];

    public static array $sectionPermission = [
        'group_name' => 'section management',
        'permissions' => [
            'section.management',
        ],
    ];

    public static array $basicPaymentPermissions = [
        'group_name' => 'basic payment',
        'permissions' => [
            'basic.payment.view',
            'basic.payment.update',
        ],
    ];

    public static array $contactMessagePermissions = [
        'group_name' => 'contact message',
        'permissions' => [
            'contact.message.view',
            'contact.message.delete',
        ],
    ];

    public static array $currencyPermissions = [
        'group_name' => 'currency',
        'permissions' => [
            'currency.view',
            'currency.create',
            'currency.store',
            'currency.edit',
            'currency.update',
            'currency.delete',
        ],
    ];

    public static array $customerPermissions = [
        'group_name' => 'customer',
        'permissions' => [
            'customer.view',
            'customer.bulk.mail',
            'customer.update',
            'customer.delete',
        ],
    ];

    public static array $languagePermissions = [
        'group_name' => 'language',
        'permissions' => [
            'language.view',
            'language.create',
            'language.store',
            'language.edit',
            'language.update',
            'language.delete',
            'language.translate',
            'language.single.translate',
        ],
    ];

    public static array $menuPermissions = [
        'group_name' => 'menu builder',
        'permissions' => [
            'menu.view',
            'menu.create',
            'menu.update',
            'menu.delete',
        ],
    ];

    public static array $pagePermissions = [
        'group_name' => 'page builder',
        'permissions' => [
            'page.view',
            'page.create',
            'page.store',
            'page.edit',
            'page.update',
            'page.delete',
        ],
    ];

    public static array $pricingPermissions = [
        'group_name' => 'pricing',
        'permissions' => [
            'pricing.view',
            'pricing.management',
        ],
    ];
    public static array $socialPermission = [
        'group_name' => 'social link management',
        'permissions' => [
            'social.link.management',
        ],
    ];
    public static array $sitemapPermission = [
        'group_name' => 'sitemap management',
        'permissions' => [
            'sitemap.management',
        ],
    ];

    public static array $newsletterPermissions = [
        'group_name' => 'newsletter',
        'permissions' => [
            'newsletter.view',
            'newsletter.mail',
            'newsletter.delete',
        ],
    ];

    public static array $testimonialPermissions = [
        'group_name' => 'testimonial',
        'permissions' => [
            'testimonial.view',
            'testimonial.create',
            'testimonial.translate',
            'testimonial.store',
            'testimonial.edit',
            'testimonial.update',
            'testimonial.delete',
        ],
    ];

    public static array $faqPermissions = [
        'group_name' => 'faq',
        'permissions' => [
            'faq.view',
            'faq.create',
            'faq.translate',
            'faq.store',
            'faq.edit',
            'faq.update',
            'faq.delete',
        ],
    ];
    public static array $addonsPermissions = [
        'group_name' => 'Addons',
        'permissions' => [
            'addon.view',
            'addon.install',
            'addon.update',
            'addon.status.change',
            'addon.remove',
        ],
    ];

    private static function getSuperAdminPermissions(): array
    {
        $reflection = new ReflectionClass(__TRAIT__);
        $properties = $reflection->getStaticProperties();

        $permissions = [];
        foreach ($properties as $value) {
            if (is_array($value)) {
                $permissions[] = [
                    'group_name' => $value['group_name'],
                    'permissions' => (array) $value['permissions'],
                ];
            }
        }

        return $permissions;
    }
}
