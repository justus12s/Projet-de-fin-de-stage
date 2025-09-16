<?php
namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'auth'          => \App\Filters\AuthFilter::class, // ← AJOUT CRITIQUE
    ];

    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [
            'honeypot',
            'csrf',
            'invalidchars',
        ],
        'after' => [
            'honeypot',
            'secureheaders',
        ],
    ];

    public array $methods = [];

    public array $filters = [
        'auth' => [
            'before' => [
                'admin/*',
                'admin/dashboard/*', 
                'dashboard',
                'profile', 
                'my-books', 
                'my-reservations'
            ]
        ]
    ];
}