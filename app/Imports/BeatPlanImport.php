<?php

namespace App\Imports;

use App\Beatplan;
use App\BeatPlanData;
use App\Sitemaster;
use App\Vendor;
use App\Misallottedzones;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class BeatPlanImport implements ToModel,WithHeadingRow
{
    use Importable;
    private $recordsCache;
    private $rows = 0;

    function __construct()
    {
        $emptyCache = new \stdClass();
        $emptyCache->clients = [];
        $emptyCache->zones = [];
        $emptyCache->sites = [];
        $this->recordsCache = session('recordsCache',$emptyCache);
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
            'mpzone_name' => 'required',
            'beat_plan_date' => 'required',
            'mode' => 'required',
            'qty' => 'required',
            'client_name' => 'required',
            'current_date' => 'required'
        ];
    }
    public function model(array $row)
    {
        $cacheResponse = $this->searchRecord($row['client_name'],$row['mpzone_name'],$row['site_id']);
        $res = ['clientId' => false,'zone' => false,'siteId' => false];
        $clientId = $cacheResponse['clientId'];
        $zone = $cacheResponse['zone'];
        $siteId = $cacheResponse['siteId'];
        if(!$clientId){
          $clientId = $this->isClientExist($row['client_name']);
          if($clientId) array_push($this->recordsCache->clients, 
            ['clientName' => $row['client_name'],'clientId' => $clientId]);
        }
        if(!$siteId){
          $siteId = $this->isSiteExist($row['site_id'],$row['mpzone_name'],$clientId); 
          if($siteId) array_push($this->recordsCache->sites, 
            ['siteId' => $row['site_id'],'generatedSiteId' => $siteId]);
        } 
        if(!$zone){
          $zone = $this->isZoneExist($row['mpzone_name']);
          if($zone) array_push($this->recordsCache->zones,
            ['zone' => $row['mpzone_name']]);
        } 
        //dd($siteId);
        if($clientId && $zone && $siteId){
            session(['recordsCache' => $this->recordsCache]);
            $beatPlan = Beatplan::firstOrNew([
                'client_id'     => $clientId,
                'mp_zone'    => $row['mpzone_name'], 
                'added_date' => $row['current_date'], 
                'effective_date'    => $row['beat_plan_date'], 
                'mode'    => $row['mode'], 
                'added_by' => auth()->user()->id 
            ]);
			$beatPlan->client_id = $clientId;
			$beatPlan->mp_zone = $row['mpzone_name'];
			$beatPlan->added_date = $row['current_date'];
			$beatPlan->effective_date = $row['beat_plan_date'];
			$beatPlan->mode = $row['mode'];
			$beatPlan->added_by = auth()->user()->id;
			$beatPlan->save();
            ++$this->rows;
            return new BeatPlanData([
                'beatplan_id' => $beatPlan->id,
                'site_id' => $siteId,
                'quantity' => $row['qty']
            ]);
        }else{
            return null;
        }
    }
    private function isZoneExist($zone='')
    {
        if(auth()->user()->type == 'subadmin'){
            if($zone != ''){
                $exist = Sitemaster::where(['mp_zone'=>$zone,'created_by_id' => auth()->user()->id])->exists();
                return $exist;
            }
        }elseif (auth()->user()->type == 'mis') {
            if($zone != ''){
                $exist = Misallottedzones::where(['mp_zones'=>$zone,'mis_user_id' => auth()->user()->id])->exists();
                return $exist;
            }
        }
    }
    private function isClientExist($name='')
    {
        if(auth()->user()->type == 'subadmin'){
            if($name != ''){
                $exist = Vendor::where(['name'=>$name,'created_by_id' => auth()->user()->id])->first();
                return $exist != null ? $exist['id'] : false;
            }
        }elseif (auth()->user()->type == 'mis') {
            if($name != ''){
                $exist = Vendor::where(['name'=>$name,'created_by_id' => auth()->user()->created_by_id])->first();
                return $exist != null ? $exist['id'] : false;
            }
        }
    }
    private function isSiteExist($siteid='',$zone='', $clientId='')
    {
        if(auth()->user()->type == 'subadmin'){
            if($zone != ''){
                $exist = Sitemaster::where(['mp_zone'=>$zone,'client_id'=>$clientId,'site_id'=>$siteid,'created_by_id' => auth()->user()->id])->first();
                return $exist != null ? $exist['id'] : false;
            }
        }elseif (auth()->user()->type == 'mis') {
            if($zone != ''){
                $exist = Misallottedzones::where(['mp_zone'=>$zone,'client_id'=>$clientId,'site_id'=>$siteid,'mis_user_id' => auth()->user()->id])->first();
                return $exist != null ? $exist['id'] : false;
            }
        }
    }
    private function searchRecord($clientName,$zone,$siteId)
    {
        $res = ['clientId' => false,'zone' => false,'siteId' => false];
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
        return $res;
    }
    public function getRowCount(): int
    {
        return $this->rows;
    }
}
