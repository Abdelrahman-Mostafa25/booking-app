<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'teache/*',
        'teache',
        'booking/*',
        'booking',
        'hall_supervisor',
        'hall_supervisor/*',
        'supervisor_info',
        'supervisor_info/*',
        'hall_photo',
        'hall_photo/*'
    ];
}
