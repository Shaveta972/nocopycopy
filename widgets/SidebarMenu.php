<?php
namespace app\widgets;

use yii\base\Widget;
use yii\bootstrap\Nav;
use yii\widgets\Menu;

class SidebarMenu extends Widget
{
    public function run()
    {
        $result = Menu::widget([
            'encodeLabels' => false,
            'activateItems' => true,
            'activateParents' => true,
            'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
            'options' => [
                'class' => 'sidebar-menu',
                'data-widget' => 'tree'
            ],
            'items' => [
                [
                    'label' => 'MAIN NAVIGATION',
                    'template' => '{label}',
                    'url' => [
                        '#'
                    ],
                    'options' => [
                        'class' => 'header'
                    ]
                ],
                [
                    'label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>',
                    'url' => [
                        '/admin/dashboard/index'
                    ]
                ],
                [
                    'label' => '<i class="fa fa-user"></i> <span>Users</span>',
                    'url' => [
                        '/admin/user/index'
                    ]
                ],
                [
                    'label' => '<i class="fa fa-user"></i> <span>Testimonials</span>',
                    'url' => [
                        '/admin/testimonial'
                    ]
                ],
                // [
                //     'label' => '<i class="fa fa-list-ul     "></i> <span>Features</span>',
                //     'url' => [
                //         '/admin/features'
                //     ]
                // ],
                [
                    'label' => '<i class="fa fa-list"></i> <span>Manage Category</span>',
                    'url' => [
                        '/admin/category'
                    ]
                ],
                [
                    'label' => '<i class="fa fa-user"></i> <span>User Credit Settings</span>',
                    'url' => [
                        '/admin/credit-user-type'
                    ]
                ],
                [
                    'label' => '<i class="fa fa-user"></i> <span>Document Credit Settings</span>',
                    'url' => [
                        '/admin/credit'
                    ]
                    ],
                    [
                        'label' => '<i class="fa fa-list"></i> <span>Plans</span>',
                        'url' => [
                            '/admin/plan'
                        ]
                    ],
                    [
                        'label' => '<i class="fa fa-list"></i> <span>Sales Reports</span>',
                        'url' => [
                            '/admin/reports/sales'
                        ]
                    ],
                    [
                        'label' => '<i class="fa fa-list"></i> <span>Credit Reports</span>',
                        'url' => [
                            '/admin/reports/credit'
                        ]
                    ],
                    [
                        'label' => '<i class="fa fa-list"></i> <span>Enquiry Requests</span>',
                        'url' => [
                            '/admin/user/enquiries'
                        ]
                    ],
            ]
        ]);

        return $result;
    }
}
