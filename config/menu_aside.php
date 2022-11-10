<?php
// Aside menu
return [

    'superadmin' => [
        // Dashboard
        [
            'title' => 'Inicio',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/',
            'new-tab' => false,
        ],

        // Custom
        [
            'section' => 'ADMINISTRACIÓN',
        ],
        [
            'title' => 'Usuarios',
            'icon' => 'media/svg/icons/General/User.svg',
            'bullet' => 'dot',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Lista',
                    'page' => 'admin/usuario'
                ],
                [
                    'title' => 'Crear',
                    'page' => 'admin/usuario/create'
                ]
            ]
        ],
        [
            'title' => 'Automóviles',
            'icon' => 'icomoon-car',
            'bullet' => 'dot',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Inspecciones',
                    'page' => 'admin/inspection/car'
                ]
            ]
        ],
        [
            'title' => 'Embarcaciones',
            'icon' => 'icomoon-boat',
            'bullet' => 'dot',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Lista',
                    'page' => 'admin/inspection/boat'
                ]
            ]
        ],
        [
            'title' => 'Siniestros',
            'icon' => 'icomoon-car-crash',
            'bullet' => 'dot',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Lista',
                    'page' => 'admin/sinister/car'
                ]
            ]
        ],
        [
            'title' => 'Estadísticas',
            'icon' => 'media/svg/icons/Shopping/Chart-bar1.svg',
            'bullet' => 'dot',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Automóviles',
                    'page' => 'admin/inspection/car/charts'
                ],
                [
                    'title' => 'Embarcaciones',
                    'page' => 'admin/inspection/boat/charts'
                ],
                [
                    'title' => 'Siniestros',
                    'page' => 'admin/sinister/car/charts'
                ]
            ]
        ],
    ]

];
