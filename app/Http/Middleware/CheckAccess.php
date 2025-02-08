<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccess
{
   /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
   public function handle(Request $request, Closure $next): Response
   {
      // Contoh logika: cek jika user tidak memiliki hak akses
      if (!$request->user() || $request->user()->role !== '1') {
         abort(404); // Mengarahkan ke tampilan 404
      }

      return $next($request);
   }
}
