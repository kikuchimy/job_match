<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    /**
     * dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $params = $request->query();
        $job_offers = JobOffer::myJobOffer($params)->paginate(5);

        return view('dashboard', compact('job_offers'));
    }
}
