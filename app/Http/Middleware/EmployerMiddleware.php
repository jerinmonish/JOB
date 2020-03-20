<?php
namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Closure;

class EmployerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->role == 'employer')
        {
            if(empty($request->user()->first_name) || empty($request->user()->last_name) || empty($request->user()->email) || empty($request->user()->organisation_name) || empty($request->user()->specialised_in) || empty($request->user()->mobile_no)){
                return redirect('profile')->with(['error' => "You need to update profile inorder to access site."]);
            } else {
                return $next($request);
            }
        } else {
            return new Response(view('unauthorized')->with('role', 'Employer'));
        }
    }
}
