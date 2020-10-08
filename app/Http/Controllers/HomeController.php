<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Beatplans;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /*return view('dashboard');*/
        /*if(auth()->user()->type == 'admin'){
            $plans = Beatplans::leftjoin('users', function($join){
                $join->on('users.id','=','beat_plans.alloted_user_id'); 
            })->select('beat_plans.*','users.name')->paginate(10);
        }else{
            $plans = Beatplans::leftjoin('users', function($join){
                $join->on('users.id','=','beat_plans.alloted_user_id'); 
            })->where('beat_plans.alloted_user_id','=',auth()->user()->id)->select('beat_plans.*','users.name')->paginate(10);
        }*/
        return view('pages.beat-plan-server-side');
    }
    public function serversideBeatplan(Request $request){
        $orderby = $request->input('order.0.column');
        $sort['col'] = $request->input('columns.' . $orderby . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $query = Beatplans::leftjoin('users', function($join){
            $join->on('users.id','=','beat_plans.alloted_user_id'); 
        })->select('beat_plans.id','beat_plans.site_id', 'beat_plans.plan_date', 'beat_plans.site_name', 'beat_plans.site_type', 'beat_plans.maintenance_point', 'beat_plans.beat_plan_ltr', 'beat_plans.technician_name', 'beat_plans.technician_mobile', 'beat_plans.route_plan', 'beat_plans.ro_name','beat_plans.vehicle_no','beat_plans.latitude','beat_plans.longitude','beat_plans.driver_name','beat_plans.driver_mobile','beat_plans.filler_name','beat_plans.filler_mobile','beat_plans.created_at','users.name');
        if(auth()->user()->type !== 'admin'){
            $query->where('beat_plans.alloted_user_id','=',auth()->user()->id);
        }
        if(!empty($request->input('search.value'))){
            $query->where('beat_plans.site_id', 'like', '%'. $request->input('search.value') .'%')
            ->orWhere('beat_plans.plan_date', 'like', '%'. $request->input('search.value') .'%');
        }
        $output['draw'] = intval($request->input('draw'));
        $output['recordsTotal'] = $query->count();
        $output['recordsFiltered'] = $output['recordsTotal'];
        $start = $request->input('start');
        $limit = $request->input('length');
        $output['data'] = $query
        ->orderBy('beat_plans.id', $sort['dir'])
        ->when(($limit != '-1'), function ($query, $start) {
            return $query->skip($start);
        })
        ->take($request->input('length',10))
        ->get();
        return json_encode($output);
    }
}
