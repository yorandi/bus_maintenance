<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Middleware untuk mengecek role user sebelum mengakses resource tertentu
     *
     * Cara pakai di route:
     * Route::middleware('role:admin')->group(function () {
     *     // hanya admin yang bisa akses routes di sini
     * });
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect('login');
        }

        $userRole = strtolower(trim((string) $user->role?->nama_role));
        $allowedRoles = array_map(static fn ($role) => strtolower(trim((string) $role)), $roles);

        $roleAliases = [
            'admin' => ['admin'],
            'manager' => ['manager', 'manager teknik'],
            'manager teknik' => ['manager', 'manager teknik'],
            'mechanic' => ['mechanic', 'mekanik'],
            'mekanik' => ['mechanic', 'mekanik'],
            'driver' => ['driver', 'sopir'],
            'sopir' => ['driver', 'sopir'],
        ];

        $userAliases = $roleAliases[$userRole] ?? [$userRole];
        $matched = ! empty(array_intersect($allowedRoles, $userAliases));

        // Jika user role ada di list roles yang diizinkan, lanjutkan
        if ($matched) {
            return $next($request);
        }

        // Jika tidak, kembalikan error
        return response('Unauthorized. You do not have access to this resource.', 403);
    }
}
