<?php

namespace App\Imports;

use App\Sitemaster;
use App\Vendor;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;

class SiteMasterImport implements ToModel,WithHeadingRow, WithValidation
{
	use Importable;
	private $recordsCache;
	private $rows = 0;

	function __construct()
	{
		$emptyCache = new \stdClass();
        $emptyCache->clients = [];
        $emptyCache->techs = [];
        $this->recordsCache = session('siteRecordsCache',$emptyCache);

    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function rules(): array
    {
    	return [
    		'site_id' => 'required',
            'site_name' => 'required',
            'mp_zone' => 'required',
            'dg1_make' => 'required',
            'dg1_rating_in_kva' => 'required',
            'technician_name' => 'required',
            'technician_contact1' => 'required|digits:10',
            'energy_man_name' => 'required',
            'energy_man_contact' => 'required|digits:10',
            'client_name' => 'required'
        ];
    }
    public function model(array $row)
    {

    	$cacheResponse = $this->searchRecord($row['client_name'],$row['mp_zone'],$row['site_id'],$row['technician_contact1']);
        //dd($cacheResponse);
    	$res = ['clientId' => false, 'technicianId' => false];
    	$clientId = $cacheResponse['clientId'];
    	$zone = $cacheResponse['zone'];
    	$siteId = $cacheResponse['siteId'];
        $technicianId = $cacheResponse['technicianId'];
        if(!$clientId){
          $clientId = $this->isClientExist($row['client_name']);
          if($clientId) array_push($this->recordsCache->clients, 
           ['clientName' => $row['client_name'],'clientId' => $clientId]);
      }
      if(!$technicianId){
        $technicianId = $this->isTechnicianExist($row['technician_contact1'],$clientId);
        if($technicianId) array_push($this->recordsCache->techs, 
            ['technicianContact' => $row['technician_contact1'],'technicianId' => $technicianId]);   
    }
    //dd($technicianId);
    if (!$technicianId && $clientId) {
        $technicianId = $this->createTechnician($row['technician_name'], $row['technician_contact1'],$clientId);
        if($technicianId) array_push($this->recordsCache->techs, 
            ['technicianContact' => $row['technician_contact1'],'technicianId' => $technicianId]);   
    }
    if($clientId && $row['site_name'] && $technicianId){
      session(['siteRecordsCache' => $this->recordsCache]);

      $data = [
       'site_id' => $row['site_id'],
       'unique_site_id' => $row['unique_site_id'],
       'site_name' => $row['site_name'],
       'cluster_jc' => $row['cluster_jc'],
       'district' => $row['district'],
       'mp_zone' => $row['mp_zone'],
       'site_address' => $row['site_address'],
       'latitude' => $row['latitude'],
       'longitude' => $row['longitude'],
       'site_type' => $row['site_type'],
       'bts' => $row['bts'],
       'site_category' => $row['site_category'],
       'battery_bank_ah' => $row['battery_bank_ah'],
       'cph' => $row['cph'],
       'indoor_bts' => $row['indoor_bts'],
       'outdoor_bts' => $row['outdoor_bts'],
       'dg1_make' => $row['dg1_make'],
       'dg2_make' => $row['dg2_make'],
       'dg1_rating_in_kva' => $row['dg1_rating_in_kva'],
       'dg2_rating_in_kva' => $row['dg2_rating_in_kva'],
       'eb_status' => $row['eb_status'],
       'eb_type' => $row['eb_type'],
       'eb_load_kw' => $row['eb_load_kw'],
       'technician_id' => $technicianId,
       'technician_name' => $row['technician_name'],
       'technician_contact2' => $row['technician_contact2']??'',
       'technician_contact1' => $row['technician_contact1']??'',
       'cluster_incharge_name' => $row['cluster_incharge_name'],
       'cluster_incharge_contact1' => $row['cluster_incharge_contact1'],
       'cluster_incharge_contact2' => $row['cluster_incharge_contact2']??'',
       'cluster_incharge_email' => $row['cluster_incharge_email'],
       'zom_name' => $row['zom_name'],
       'zom_contact' => $row['zom_contact'],
       'zom_email' => $row['zom_email'],
       'energy_man_name' => $row['energy_man_name'],
       'energy_man_contact' => $row['energy_man_contact'],
       'energy_man_email' => $row['energy_man_email'],
       'circle_facility_head_name' => $row['circle_facility_head_name'],
       'circle_facility_head_contact' => $row['circle_facility_head_contact'],
       'circle_facility_head_email' => $row['circle_facility_head_email'],
       'created_by_id' => auth()->user()->id,
       'client_id'     => $clientId,
   ];
   $site_data = new Sitemaster($data);
   ++$this->rows;
   return $site_data;
}else{
  return null;
}
}

private function isClientExist($name='')
{
 if(auth()->user()->type == 'subadmin'){
  if($name != ''){
   $exist = Vendor::where(['name'=>$name, 'type'=>'client' ,'created_by_id' => auth()->user()->id])->first();
   return $exist != null ? $exist['id'] : false;
}
}elseif (auth()->user()->type == 'mis') {
  if($name != ''){
   $exist = Vendor::where(['name'=>$name, 'type'=>'client', 'created_by_id' => auth()->user()->created_by_id])->first();
   return $exist != null ? $exist['id'] : false;
}
}
}
private function isTechnicianExist($contact='', $clientId='')
{
    if($contact != ''){
        $exist = User::where(['contact'=>$contact, 'type'=>'technician', 'client_id' => $clientId, 'created_by_id' => auth()->user()->id])->orWhere(function($q) use($contact,$clientId){
           $q->where(['contact'=>$contact, 'created_by_id' => $clientId]);
       })->first();
        return $exist != null ? $exist['id'] : false;
    }
}

private function searchRecord($clientName,$zone,$siteId,$technicianContact)
{
 $res = ['clientId' => false,'zone' => false,'siteId' => false,'technicianId' => false];
 if(!empty($this->recordsCache->clients)){
  foreach ($this->recordsCache->clients as $key => $value) {
   if($clientName == $value['clientName']){
    $res['clientId'] = $value['clientId'];
}
}
}
if(!empty($this->recordsCache->zones)){
  foreach ($this->recordsCache->zones as $key => $value) {
   if($zone == $value['zone']){
    $res['zone'] = true;
}
}
}
if(!empty($this->recordsCache->sites)){
  foreach ($this->recordsCache->sites as $key => $value) {
   if($siteId == $value['siteId']){
    $res['siteId'] = $value['generatedSiteId'];
}
}
}
if(!empty($this->recordsCache->techs)){
    foreach ($this->recordsCache->techs as $key => $value) {
        if($technicianContact == $value['technicianContact']){
            $res['technicianId'] = $value['technicianId'];
        }
    }

}
return $res;
}
public function getRowCount(): int
{
 return $this->rows;
}
private function createTechnician($name='', $contact, $clientId)
{
    $id = false;
    if($name && $contact && $clientId){
        if(auth()->user()->type == 'subadmin'){
            if (!User::where(['contact'=>$contact,'created_by_id'=>auth()->user()->id])->orWhere(function($q) use($contact,$clientId){ $q->where(['contact'=>$contact, 'created_by_id' => $clientId]);})->exists()) {
                $tech = new User;
                $tech->name = $name;
                $tech->contact = $contact;
                $tech->password = Hash::make($contact);
                $tech->type = 'technician';
                $tech->status = 'active';
                $tech->created_by_id = auth()->user()->id;
                $tech->client_id = $clientId;
                if($tech->save()){
                    $id = $tech->id;
                }       
            }
        }
    }
    return $id;
}
}
