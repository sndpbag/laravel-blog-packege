<?php

return [
    'sidebar' => [
        // ... others menu item
        [
            'title' => 'Blog',
            'route' => 'blog.index', // new route name
            'icon' => '<svg>...</svg>', // icon
            'active_on' => 'blog.*'
        ],
    ]
];