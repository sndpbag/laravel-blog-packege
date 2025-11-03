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
        [
            'title' => 'Blog Categories',
            'route' => 'blog-categories.index',  
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>',
            'active_on' => 'blog-categories.*'  
        ],
         [
            'title' => 'Comments',
            'route' => 'comments.index', // কমেন্ট রুট
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
            'active_on' => 'comments.*'  
        ],
    ]
];