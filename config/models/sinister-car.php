
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
    'image' => [
        'dir'  => 'public/img/sinistercar/uploads/',
        'validation' => 'mimes:jpg,jpeg,png|max:2048',
        'validation_mimes' => 'Imágenes solo en formato jpeg, jpg o png son permitidas.',
        'validation_max'   => 'Lo lamento! Máximo de peso por imagen es de 2MB'
    ]
];
