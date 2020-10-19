<?php

namespace App\Helpers;
use App\User;
use App\Vendor;
use App\BeatPlanData;
use App\Vehiclemaster;
use App\Routes;
use App\Beatplan;
use App\TripData;
use App\Misallottedzones;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class Helper
{
	public static function getMoblieByid($id='')
	{
		if(isset($id) && !empty($id)){
			return User::find($id)['contact'];
		}else{
			return null;
		}
	}
	public static function getMoblieByVendorId($id='')
	{
		if(isset($id) && !empty($id)){
			return User::find(Vendor::find($id)->user_id)->contact; 
		}
	}
	public static function getQtyByBeatplanIdAndDataid($beatplan_id='',$data_id='')
	{
		if(isset($data_id) && !empty($data_id) && isset($beatplan_id) && !empty($beatplan_id)){
			$beatplan =  BeatPlanData::where(['site_id' => $data_id, 'beatplan_id' => $beatplan_id])->first();
			return $beatplan['quantity'];
		}
	}
	public static function getVehicleNumberByVehicleId($VehicleId)
	{
		if(isset($VehicleId) && !empty($VehicleId)){
			return Vehiclemaster::find($VehicleId)->vehicle_no;
		}
	}
	public static function getRouteNameByRouteId($route_id)
	{
		if(isset($route_id) && !empty($route_id)){
			return Routes::find($route_id)->route_name;
		}
	}

	public static function getZoneByBeatplanId($beatid)
	{
		if(isset($beatid) && !empty($beatid)){
			return Beatplan::find($beatid)->mp_zone;
		}
	}

	public static function getQuantityByTripId($tripid)
	{
		if(isset($tripid) && !empty($tripid)){
			return TripData::leftjoin('beatplan_data', function($q){
				$q->on('beatplan_data.beatplan_id','=','trip_data.beatplan_id');
				$q->on('beatplan_data.site_id','=','trip_data.data_id');
			})->where(['trip_data.trip_id' => $tripid])->selectRaw('sum(beatplan_data.quantity) as qty')->get('qty')->pluck('qty');
		}
	}

	public static function sendEmail($to_email, $data, string $template)
	{
		$response = "Email not sent!";
		if(isset($to_email) && !empty($to_email)){
			$response = Mail::send($template, ['data' => $data], function($message) use ($to_email,$data) {
				$message->to($to_email)
				->subject($data['trip_id'].'/'.$data['route'].'/'.$data['vehicle']);
				$message->from('info@rottweilerservices.com','Taplog');
			});
		}
		return $response;
	}
	
	public static function getQtyByTripdataIdAndDataid(){
		return true;
	}

	public static function getAdminIdOfClientByClientId($id='')
	{
		if(isset($id) && !empty($id)){
			return Vendor::find($id)->created_by_id;
		}
	}
	public static function getClientIdsByZoneAndId($zone='',$userId='')
	{
		$response = [];
		$data = Misallottedzones::where(['mp_zones' => $zone, 'mis_user_id' => $userId])->select('allotted_client_id')->get();
		if (isset($data) && !empty($data)) {
			foreach ($data as $key ) {
				$response[] = $key->allotted_client_id;
			}
			return $response;
		}
	}
	
	public static function allotedZonesAndClientId($userId='')
	{
		if($userId){
		// return Misallottedzones::where(['mis_user_id' => $userId])->select(DB::raw('group_concat(mp_zones) as zones'),DB::raw('group_concat(allotted_client_id)as clients'))->first();
			return Misallottedzones::where(['mis_user_id' => $userId])->select('mp_zones as zone','allotted_client_id as client')->get();
		}
	}

	public static function filterArray( $array, $allowed = [] ) {
		return array_filter(
			$array,
        function ( $val, $key ) use ( $allowed ) { // N.b. $val, $key not $key, $val
        	return isset( $allowed[ $key ] ) && ( $allowed[ $key ] === true || $allowed[ $key ] === $val );
        },
        ARRAY_FILTER_USE_BOTH
    );
	}
	public static function filterKeyword( $data, $search, $field = '' ) {
		$filter = '';
		if ( isset( $search['value'] ) ) {
			$filter = $search['value'];
		}
		if ( ! empty( $filter ) ) {
			if ( ! empty( $field ) ) {
				if ( strpos( strtolower( $field ), 'date' ) !== false ) {
                // filter by date range
					$instance = new Helper();
					$data = $instance->filterByDateRange( $data, $filter, $field );
				} else {
                // filter by column
					$data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
						return (boolean) preg_match( "/$filter/i", $a[ $field ] );
					} );
				}

			} else {
            // general filter
				$data = array_filter( $data, function ( $a ) use ( $filter ) {
					return (boolean) preg_grep( "/$filter/i", (array) $a );
				} );
			}
		}

		return $data;
	}
	public function filterByDateRange( $data, $filter, $field ) {
    	// filter by range
		if ( ! empty( $range = array_filter( explode( '|', $filter ) ) ) ) {
			$filter = $range;
		}
		if ( is_array( $filter ) ) {
			foreach ( $filter as &$date ) {
            // hardcoded date format
				$date = date_create_from_format( 'd-m-Y', stripcslashes( $date ) );
			}
        	// filter by date range
			$data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
            // hardcoded date format
				$current = date_create_from_format( 'd-m-Y', $a[ $field ] );
				$from    = $filter[0];
				$to      = $filter[1];
				if ( $from <= $current && $to >= $current ) {
					return true;
				}

				return false;
			} );
		}
		return $data;
	}
	public static function removePreviousAvatar($path){
		if(Storage::delete($path)) {
			return true;
		}
	}
}