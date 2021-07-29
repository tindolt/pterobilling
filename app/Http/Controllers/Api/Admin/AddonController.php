<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Addon;
use App\Models\AddonCycle;
use App\Models\ServerAddon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddonController extends ApiController
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|numeric',
            'resource' => 'required|string|in:ram,cpu,disk,database,backup,extra_port,dedicated_ip',
            'amount' => 'required|integer|gte:1',
            'category' => 'required|array',
            'global_limit' => 'nullable|integer|gte:0',
            'per_client_limit' => 'nullable|integer|gte:0',
            'per_server_limit' => 'nullable|integer|gte:0',
            'cycle' => 'required|array'
        ]);

        if ($validator->fails())
            return $this->respondJson(['errors' => $validator->errors()->all()]);

        $addon = Addon::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'resource' => $request->input('resource'),
            'amount' => $request->input('amount'),
            'categories' => json_encode($request->input('category')),
            'global_limit' => $request->input('global_limit'),
            'per_client_limit' => $request->input('per_client_limit'),
            'per_server_limit' => $request->input('per_server_limit'),
            'order' => $request->input('order'),
        ]);

        foreach ($request->input('cycle') as $cycle) {
            $validator = Validator::make($cycle, [
                'cycle_length' => 'required|integer|gte:1',
                'cycle_type' => 'required|integer|in:0,1,2,3,4',
                'init_price' => 'required|numeric|gte:0',
                'renew_price' => 'required|numeric|gte:0',
                'setup_fee' => 'required|numeric|gte:0',
            ]);

            if ($validator->fails()) continue;

            AddonCycle::create([
                'addon_id' => $addon->id,
                'cycle_length' => $cycle['cycle_length'],
                'cycle_type' => $cycle['cycle_type'],
                'init_price' => $cycle['init_price'],
                'renew_price' => $cycle['renew_price'],
                'setup_fee' => $cycle['setup_fee'],
            ]);
        }

        return $this->respondJson(['success' => 'You have created a plan add-on successfully!']);
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|numeric',
            'resource' => 'required|string|in:ram,cpu,disk,database,backup,extra_port,dedicated_ip',
            'amount' => 'required|integer|gte:1',
            'category' => 'required|array',
            'global_limit' => 'nullable|integer|gte:0',
            'per_client_limit' => 'nullable|integer|gte:0',
            'per_server_limit' => 'nullable|integer|gte:0',
            'cycle' => 'required|array'
        ]);

        if ($validator->fails())
            return $this->respondJson(['errors' => $validator->errors()->all()]);

        $addon = Addon::find($id);
        $addon->name = $request->input('name');
        $addon->description = $request->input('description');
        $addon->resource = $request->input('resource');
        $addon->amount = $request->input('amount');
        $addon->categories = json_encode($request->input('category'));
        $addon->global_limit = $request->input('global_limit');
        $addon->per_client_limit = $request->input('per_client_limit');
        $addon->per_server_limit = $request->input('per_server_limit');
        $addon->order = $request->input('order');
        $addon->save();

        $delete_failed = false;
        
        foreach (AddonCycle::where('addon_id', $id)->get() as $cycle) {
            if (ServerAddon::where('addon_id', $id)->doesntExist()) {
                $cycle->delete();
            } else {
                $delete_failed = true;
            }
        }

        foreach ($request->input('cycle') as $cycle) {
            $validator = Validator::make($cycle, [
                'cycle_length' => 'required|integer|gte:1',
                'cycle_type' => 'required|integer|in:0,1,2,3,4',
                'init_price' => 'required|numeric|gte:0',
                'renew_price' => 'required|numeric|gte:0',
                'setup_fee' => 'required|numeric|gte:0',
            ]);

            if ($validator->fails()) continue;

            AddonCycle::create([
                'addon_id' => $addon->id,
                'cycle_length' => $cycle['cycle_length'],
                'cycle_type' => $cycle['cycle_type'],
                'init_price' => $cycle['init_price'],
                'renew_price' => $cycle['renew_price'],
                'setup_fee' => $cycle['setup_fee'],
            ]);
        }
        
        return $this->respondJson(['success' => 'You have updated the plan add-on successfully!', 'delete_failed' => $delete_failed]);
    }
    
    public function delete($id)
    {
        if (ServerAddon::where('addon_id', $id)->doesntExist()) {
            return $this->respondJson(['error' => 'You cannot delete this plan add-on because some servers are still using it!']);
        }

        $addon = Addon::find($id);
        $addon->delete();

        return $this->respondJson(['success' => 'You have deleted the plan add-on successfully!']);
    }
}
