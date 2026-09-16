<?php

return [
    'navigation' => [
        ['label' => 'Institution', 'href' => '/about', 'panel' => 'institution'],
        ['label' => 'Science', 'href' => '/science', 'panel' => 'science'],
        ['label' => 'Platforms', 'href' => '/platforms', 'panel' => 'platforms'],
        ['label' => 'Divisions', 'href' => '/divisions', 'panel' => 'divisions'],
        ['label' => 'Evidence', 'href' => '/science/evidence', 'panel' => 'evidence'],
        ['label' => 'Founder', 'href' => '/founder'],
        ['label' => 'Future', 'href' => '/future', 'panel' => 'future'],
    ],

    'panels' => [
        'institution' => [
            ['label' => 'About ORIGINA', 'href' => '/about'],
            ['label' => 'Africa Originating', 'href' => '/africa'],
            ['label' => 'Culture & Talent', 'href' => '/culture'],
            ['label' => 'Intellectual Property', 'href' => '/intellectual-property'],
        ],
        'science' => [
            ['label' => 'ORIGINA Labs™', 'href' => '/labs'],
            ['label' => 'Biology First™', 'href' => '/biology-first'],
            ['label' => 'Scientific Position', 'href' => '/science#position'],
            ['label' => 'Development Framework', 'href' => '/science#framework'],
            ['label' => 'Research', 'href' => '/labs#research'],
        ],
        'platforms' => [
            ['label' => 'Platform overview', 'href' => '/platforms'],
            ['label' => 'BMX-24™', 'href' => '/divisions/b-melanox'],
            ['label' => 'BRP-1™', 'href' => '/intellectual-property'],
        ],
        'divisions' => [
            ['label' => 'B-Melanox™', 'href' => '/divisions/b-melanox'],
            ['label' => 'BettyWorld', 'href' => '/divisions/bettyworld'],
            ['label' => 'BValence™', 'href' => '/divisions/bvalence'],
            ['label' => 'DIVINE™', 'href' => '/divisions/divine'],
            ['label' => 'NOVIA™', 'href' => '/divisions/novia'],
            ['label' => 'Skin Safari™', 'href' => '/divisions/skin-safari'],
        ],
        'evidence' => [
            ['label' => 'Scientific Evidence', 'href' => '/science/evidence'],
            ['label' => 'Quality & Safety', 'href' => '/science/quality'],
            ['label' => 'Regulatory Science', 'href' => '/science/regulatory'],
            ['label' => 'Clinical Research', 'href' => '/science/evidence#clinical'],
            ['label' => 'Responsible Science', 'href' => '/science/responsible-science'],
        ],
        'future' => [
            ['label' => 'Academy', 'href' => '/future/academy'],
            ['label' => 'Ventures', 'href' => '/future/ventures'],
            ['label' => 'Research Institute', 'href' => '/future/research-institute'],
            ['label' => 'Foundation', 'href' => '/future/foundation'],
            ['label' => 'Product Divisions', 'href' => '/future/product-divisions'],
            ['label' => '∞ Unnamed Division', 'href' => '/future/unnamed'],
        ],
    ],

    'footer' => [
        'institution' => [
            'title' => 'Institution',
            'links' => [
                ['label' => 'About', 'href' => '/about'],
                ['label' => 'Founder', 'href' => '/founder'],
                ['label' => 'Africa Originating', 'href' => '/africa'],
                ['label' => 'Biology First™', 'href' => '/biology-first'],
                ['label' => 'Culture & Talent', 'href' => '/culture'],
            ],
        ],
        'science' => [
            'title' => 'Science',
            'links' => [
                ['label' => 'ORIGINA Labs™', 'href' => '/labs'],
                ['label' => 'Scientific Position', 'href' => '/science#position'],
                ['label' => 'Development Framework', 'href' => '/science#framework'],
            ],
        ],
        'platforms' => [
            'title' => 'Platforms',
            'links' => [
                ['label' => 'BMX-24™', 'href' => '/divisions/b-melanox'],
                ['label' => 'BRP-1™', 'href' => '/intellectual-property'],
                ['label' => 'Intellectual Property', 'href' => '/intellectual-property'],
            ],
        ],
        'divisions' => [
            'title' => 'Divisions',
            'links' => [
                ['label' => 'B-Melanox™', 'href' => '/divisions/b-melanox'],
                ['label' => 'BettyWorld', 'href' => '/divisions/bettyworld'],
                ['label' => 'BValence™', 'href' => '/divisions/bvalence'],
                ['label' => 'DIVINE™', 'href' => '/divisions/divine'],
                ['label' => 'NOVIA™', 'href' => '/divisions/novia'],
                ['label' => 'Skin Safari™', 'href' => '/divisions/skin-safari'],
            ],
        ],
        'evidence' => [
            'title' => 'Evidence & Quality',
            'links' => [
                ['label' => 'Scientific Evidence', 'href' => '/science/evidence'],
                ['label' => 'Quality & Safety', 'href' => '/science/quality'],
                ['label' => 'Regulatory Science', 'href' => '/science/regulatory'],
                ['label' => 'Clinical Research', 'href' => '/science/evidence#clinical'],
                ['label' => 'Responsible Science', 'href' => '/science/responsible-science'],
            ],
        ],
        'future' => [
            'title' => 'Future',
            'links' => [
                ['label' => 'Academy', 'href' => '/future/academy'],
                ['label' => 'Ventures', 'href' => '/future/ventures'],
                ['label' => 'Research Institute', 'href' => '/future/research-institute'],
                ['label' => 'Foundation', 'href' => '/future/foundation'],
                ['label' => 'Product Divisions', 'href' => '/future/product-divisions'],
                ['label' => '∞', 'href' => '/future/unnamed'],
            ],
        ],
        'connect' => [
            'title' => 'Connect',
            'links' => [
                ['label' => 'Contact', 'href' => '/contact'],
                ['label' => 'Collaboration', 'href' => '/contact?subject=scientific#enquiry-form'],
                ['label' => 'Media', 'href' => '/contact?subject=media#enquiry-form'],
                ['label' => 'Updates', 'href' => '/updates'],
            ],
        ],
    ],

    'footer_legal' => [
        ['label' => 'Privacy', 'href' => '/privacy'],
        ['label' => 'Terms', 'href' => '/terms'],
        ['label' => 'Regulatory', 'href' => '/science/regulatory'],
        ['label' => 'Quality', 'href' => '/science/quality'],
        ['label' => 'Intellectual Property', 'href' => '/intellectual-property'],
    ],

    'divisions' => [
        ['slug' => 'b-melanox', 'name' => 'B-Melanox™', 'descriptor' => 'Pigmentation science · Platform expression', 'tone' => 'melanox'],
        ['slug' => 'bettyworld', 'name' => 'BettyWorld', 'descriptor' => 'Creative division · Human expression', 'tone' => 'betty'],
        ['slug' => 'novia', 'name' => 'NOVIA™', 'descriptor' => 'Botanical direction · Emerging division', 'tone' => 'novia'],
        ['slug' => 'bvalence', 'name' => 'BValence™', 'descriptor' => 'Division expression · Development', 'tone' => 'neutral'],
        ['slug' => 'divine', 'name' => 'DIVINE™', 'descriptor' => 'Heritage expression · Development', 'tone' => 'divine'],
        ['slug' => 'skin-safari', 'name' => 'Skin Safari™', 'descriptor' => 'Skin knowledge · Human context', 'tone' => 'neutral'],
    ],
];
