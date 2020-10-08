<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Routes;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->type == 'admin') {
            $routes = Routes::paginate(10);
            return view('route.index',['routes' => $routes]);
        }elseif (auth()->user()->type == 'subadmin') {
            $routes = Routes::where('added_by_id','=',auth()->user()->id)->paginate(10);
            return view('route.index',['routes' => $routes]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'zone' => 'required',
            'route_name' => 'required',
        ]);
        if (Routes::where(['mp_zone' => $request->zone])->exists()) {
            if (!Routes::where(['mp_zone' => $request->zone, 'route_name' => $request->route_name])->exists()) {
                $route = new Routes();
                $route->mp_zone = $request->zone;
                $route->route_name = $request->route_name;
                $route->added_by_id = auth()->user()->id;
                $route->save(); 
                return back()->with('success','Route created successfully!');
            }else{
                return back()->with('error','Route already exist for this zone!');
            }
        }else{
            return back()->with('error','The zone you have entered is not valid. Please select valid zone!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'zone' => 'required',
            'route_name' => 'required',
        ]);
        if (Routes::where(['mp_zone' => $request->zone])->exists()) {
            if (!Routes::where(['mp_zone' => $request->zone, 'route_name' => $request->route_name])->where('id','!=',$id)->exists()) {
                $route = Routes::find($id);
                $route->mp_zone = $request->zone;
                $route->route_name = $request->route_name;
                $route->save();
                return back()->with('success','Route updated successfully!');
            }else{
                return back()->with('error','Route already exist for this zone!');
            }
        }else{
            return back()->with('error','The zone you have entered is not valid. Please select valid zone!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Routes::destroy($id);
        return back()->withStatus(__('Zone successfully deleted.'));
    }
    public function routeNameForTrip(Request $request,Routes $route, $zone)
    {
        $response = []; $numrecords = 10;
        if ($request->has('name')) {
            $search = $request->name;
            if(auth()->user()->type == 'subadmin'){
                $data = $route->where('route_name', 'LIKE', "%{$search}%")->where(['mp_zone' => $zone, 'added_by_id' => auth()->user()->id])->limit($numrecords)->get();
            }elseif (auth()->user()->type == 'mis') {
                $data = $route->where('route_name', 'LIKE', "%{$search}%")->where(['mp_zone' => $zone, 'added_by_id' => auth()->user()->created_by_id])->limit($numrecords)->get();
            }
            foreach ($data as $p) { $response[] = array("id" => $p->id, "name" => $p->route_name); }
        } else {
            $data = $route->limit($numrecords)->get();
        }
        return response()->json($response);
    }
}
