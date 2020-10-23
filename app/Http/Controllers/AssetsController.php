<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assets;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('v3.assets.index',[]);   
    }

    public function datatable(Request $request){

        if (auth()->user()->type == 'admin') {
            $query = Assets::query();
        }if (auth()->user()->type == 'subadmin') {
            $query = Assets::where('created_by_id','=',auth()->user()->id);
        }

        return \DataTables::of($query)
        ->addColumn('action', function(Assets $data) {
            $html = '';
           
            $html .= '<a href="'.route('assets.edit', $data->id).'" class="btn btn-sm btn-clean btn-icon" ><i class="la la-edit"></i></a>';

            $html .= '<a href="javascript: void(0);" data-href="'.route('asset.remove',$data->id).'" id="'. $data->id.'" class="delete btn btn-sm btn-clean btn-icon"><i class="la la-trash text-danger"></i></a>';
            

            return $html;
        })
        ->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v3.assets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asset = new Assets();
        $asset->item_name = $request->item_name;
        $asset->qty = $request->qty;
        $asset->uam = $request->uam;
        $asset->s_no = $request->s_no;
        $asset->master_location = $request->master_location;
        $asset->base_location = $request->base_location;
        $asset->mapped_with_mp = $request->mapped_with_mp;
        $asset->mapped_with_customer = $request->mapped_with_customer;
        $asset->serial_numbers = $request->serialsData;
        $asset->created_by_id = auth()->user()->id;
        $asset->save();
        return back()->with('success','assets created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // return response()->json(['status' => 'ok','id'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = Assets::find($id);
        return view('v3.assets.edit',['asset'=>$asset]);
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
        $asset =  Assets::find($id);
        $asset->item_name = $request->item_name;
        $asset->qty = $request->qty;
        $asset->uam = $request->uam;
        $asset->s_no = $request->s_no;
        $asset->master_location = $request->master_location;
        $asset->base_location = $request->base_location;
        $asset->mapped_with_mp = $request->mapped_with_mp;
        $asset->mapped_with_customer = $request->mapped_with_customer;
        $asset->save();
        return back()->with('success','assets updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Assets::destroy($id);
        return back()->withStatus(__('Assets successfully deleted.'));
    }
    public function showSerialKeys(Request $request)
    {
        $data = Assets::find($request->id);
        $responseData = ['status' => 'ok','item_name'=>$data['item_name'],'quantity'=>$data['qty'],'serial_keys'=>$data['serial_numbers']];
        return response()->json($responseData);
    }
    public function updateSerialKeys(Request $request)
    {
        $asset = Assets::find($request->id);
        $asset->serial_numbers = $request->formdata;
        $asset->created_by_id = auth()->user()->id;
        $asset->save();
        return response()->json(['status' => 'ok', 'message' => 'update successfully!']);
    }
    public function assetNameForTrip(Request $request,Assets $asset)
    {
        $response = [];$numrecords = 10;
        if ($request->has('name')) {
            $search = $request->name;
            if(auth()->user()->type == 'subadmin'){
                $data = $asset->where('item_name', 'LIKE', "%{$search}%")->where(['mapped_with_mp' => $request->zone,'created_by_id'=>auth()->user()->id])->limit($numrecords)->get();
            }elseif (auth()->user()->type == 'mis') {
                $data = $asset->where('item_name', 'LIKE', "%{$search}%")->where(['mapped_with_mp' => $request->zone,'created_by_id'=>auth()->user()->created_by_id])->limit($numrecords)->get();
            }
            foreach ($data as $p) { $response[] = array("id" => $p->id, "name" => $p->item_name); }
        } else {
            $data = $asset->limit($numrecords)->get();
        }
        return response()->json($response);
    }
}
