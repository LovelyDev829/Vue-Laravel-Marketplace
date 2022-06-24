<?php
return
    [
        'mode'                  => 'utf-8',
        'format'                => 'A4',
        'author'                => '',
        'subject'               => '',
        'keywords'              => '',
        'creator'               => 'Laravel Pdf',
        'display_mode'          => 'fullpage',
        'tempDir'               => base_path('temp/'),
        'font_path' => base_path('public/assets/fonts/'),
        'font_data' => [
            'roboto' => [
                'R'  => 'Roboto-Regular.ttf',    // regular font
                'B'  => 'Roboto-Bold.ttf',    // bold font
                'useOTL' => 0xFF,    // required for general all langs
                'useKashida' => 75,  // required for general all langs
            ],
            'hindsiliguri' => [
                'R'  => 'HindSiliguri-Regular.ttf',    // regular font
                'B'  => 'HindSiliguri-Bold.ttf',    // bold font
                'useOTL' => 0xFF,    // required for bengali lang
                'useKashida' => 75,  // required for bengali lang
            ],
            'arnamu' => [
                'R'  => 'arnamu.ttf',    // regular font
                'useOTL' => 0xFF,    // required for Armenian lang
                'useKashida' => 75,  // required for Armenian lang
            ]
        ]
    ];