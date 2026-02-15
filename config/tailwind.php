<?php

return [
    'theme' => [
        'fontFamily' => [
            'sans' => ['ui-sans-serif', 'system=ui']
        ]
    ],
    'content' => [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    'theme' => [
        'extend' => [
            'screens' => [
                'mobile' => ['max' => '480px'],
                'tablet' => ['max' => '1023px', 'min' => '481px'],
                'desktop' => ['min' => '1024px'],
            ],
            'colors' => [
                // 'primary' => "#F0E0CB",
                // 'primary-end-gradient' => "#F0E0CB80",
                // 'primary-transparent' => "#F0E0CB30",
                'primary' => "#89251c",
                'primary-end-gradient' => "#89251c80",
                'primary-transparent' => "#89251c30",
                'secondary' => "#B84F26",
                'secondary-transparent' => "#B84F2630",
                'coklat-tua' => "#89251c",
                'coklat-muda' => "#F0E0CB",
                'coklat-muda-gradient' => "#F0E0CB80",
            ]
        ]
    ],
];