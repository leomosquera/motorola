<?php
// Header menu
return [

    'items' => [
        [],
        [
            'title' => 'Inicio',
            'root' => true,
            'page' => '/',
            'new-tab' => false,
        ],
        [
            'title' => 'Administración',
            'root' => true,
            'toggle' => 'click',
            'submenu' => [
                'type' => 'classic',
                'alignment' => 'left',
                'items' => [
                    [
                        'title' => 'Usuarios',
                        'desc' => '',
                        'icon' => 'media/svg/icons/General/User.svg', // or can be 'flaticon-light' or any flaticon-*
                        'bullet' => 'dot',
                        'submenu' => [
                            [
                                'title' => 'Lista',
                                'page' => 'admin/usuario'
                            ],
                            [
                                'title' => 'Crear',
                                'page' => 'admin/create'
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
            ]
        ],
    ]

];
