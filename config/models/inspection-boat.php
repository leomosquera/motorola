
<?php
return [
    'status' => [
        'EN PROCESO' => 'EN PROCESO',
        'PROCESADA'  => 'PROCESADA'
    ],
    'profile' => [
        0 => 'SIN PERFIL',
        1 => 'ASEGURADO',
        2 => 'TALLER'
    ],
    'boat_value_money' => [
        'PESOS ARGENTINOS'   => 'PESOS ARGENTINOS',
        'DÓLARES AMERICANOS' => 'DÓLARES AMERICANOS'
    ],
    'damages' => [
        'engine_run' => [
            'FUNCIONA'   => 'FUNCIONA',
            'NO FUNCIONA' => 'NO FUNCIONA'
        ],
        'engine_auxiliary' => [
            'NO POSEE' => 'NO POSEE',
            'FUNCIONA'   => 'FUNCIONA',
            'NO FUNCIONA' => 'NO FUNCIONA'
        ],
        'damage_structural' => [
            'NO' => 'NO',
            'SI' => 'SI'
        ],
        'damage_sail' => [
            'NO' => 'NO',
            'SI' => 'SI'
        ]
    ],
    'image' => [
        'dir'  => 'public/img/inspectionboat/uploads/',
        'validation' => 'mimes:jpg,jpeg,png|max:2048',
        'validation_mimes' => 'Imágenes solo en formato jpeg, jpg o png son permitidas.',
        'validation_max'   => 'Lo lamento! Máximo de peso por imagen es de 2MB'
    ],
    'auxiliary' => [
        'dir'  => 'public/img/inspectionboat/uploads/',
        'validation' => 'mimes:jpg,jpeg,png|max:2048',
        'validation_mimes' => 'Imágenes solo en formato jpeg, jpg o png son permitidas.',
        'validation_max'   => 'Lo lamento! Máximo de peso por imagen es de 2MB'
    ],
    'document' => [
        'dir'  => 'public/img/inspectionboat/uploads/',
        'validation' => 'mimes:jpg,jpeg,png|max:2048',
        'validation_mimes' => 'Imágenes solo en formato jpeg, jpg o png son permitidas.',
    ]
];
