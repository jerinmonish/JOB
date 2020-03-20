<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Closure;

class EmployeeMiddleware
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
        if ($request->user() && $request->user()->role == 'employee')
        {
            if(empty($request->user()->first_name) || empty($request->user()->last_name) || empty($request->user()->email) || empty($request->user()->resume_doc) || empty($request->user()->specialised_in) || empty($request->user()->highest_qualification) || empty($request->user()->year_passed_out) || empty($request->user()->percentage) || empty($request->user()->exp_sal) || empty($request->user()->job_type) || empty($request->user()->mobile_no)){
                return redirect('profile')->with(['error' => "You need to update profile inorder to access site."]);
            } else {
                return $next($request);
            }
        } else {
            return new Response(view('unauthorized')->with('role', 'Employee'));            
        }
    }
}
