<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Server;
use App\Traits\CouponExpiry;
use App\Traits\DiscountExpiry;
use App\Traits\PterodactylApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PlanController extends Controller
{
    use PterodactylApi ,DiscountExpiry, CouponExpiry;

    public function index()
    {
        return view('admin.plan.index', ['title' => 'Server Plans', 'plans' => Plan::orderBy('order', 'asc')->get()]);
    }

    public function create()
    {
        $nests = Cache::get('pterodactyl_nests');

        if (is_null($nests)) {
            $nests = $this->getPanelNests();
        } elseif ($nests === false) {
            $nests = $this->getPanelNests();
        } elseif (array_key_exists('errors', $nests)) {
            $nests = $this->getPanelNests();
        }

        $eggs = [];
        foreach ($nests['data'] as $nest) {
            foreach ($nest['attributes']['relationships']['eggs']['data'] as $egg) {
                array_push($eggs, ['id' => $egg['attributes']['id'], 'name' => $egg['attributes']['name']]);
            }
        }

        return view('admin.plan.create', ['title' => "Create Plan - Server Plans", 'header1' => 'Server Plans', 'header1_route' => 'admin.plan.index', 'header_title' => 'Create Plan', 'categories' => Category::orderBy('order', 'asc')->get(), 'eggs' => $eggs, 'discounts' => $this->availableDiscounts(), 'coupons' => $this->availableCoupons()]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:plans',
            'order' => 'required|numeric',
            'category' => 'required|integer|gte:1',
            'egg' => 'required|integer|gte:1',
            'ram' => 'required|integer|gte:0',
            'cpu' => 'required|integer|gte:0',
            'disk' => 'required|integer|gte:0',
            'swap' => 'required|integer|gte:-1',
            'io' => 'required|integer|gte:10|lte:1000',
            'databases' => 'required|integer|gte:0',
            'backups' => 'required|integer|gte:0',
            'extra_ports' => 'required|integer|gte:0',
            'price' => 'required|numeric|gte:0',
            'setup_fee' => 'required|numeric|gte:0',
            'trial' => 'required|integer|gte:0',
            'discount' => 'required|integer|gte:0',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
        ]);

        $cycles = [];
        if ($request->input('monthly')) {
            array_push($cycles, 'monthly');
        }
        if ($request->input('trimonthly')) {
            array_push($cycles, 'trimonthly');
        }
        if ($request->input('biannually')) {
            array_push($cycles, 'biannually');
        }
        if ($request->input('annually')) {
            array_push($cycles, 'annually');
        }

        $coupons = [];
        foreach ($this->availableCoupons() as $coupon) {
            if ($request->has("coupon_$coupon->code")) {
                array_push($coupons, $coupon->id);
            }
        }

        $plan = Plan::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'ram' => $request->input('ram'),
            'cpu' => $request->input('cpu'),
            'disk' => $request->input('disk'),
            'swap' => $request->input('swap'),
            'io' => $request->input('io'),
            'databases' => $request->input('databases'),
            'backups' => $request->input('backups'),
            'allocations' => $request->input('extra_ports') + 1,
            'egg_id' => $request->input('egg'),
            'price' => $request->input('price'),
            'cycles' => json_encode($cycles),
            'setup_fee' => $request->input('setup_fee'),
            'trial' => $request->input('trial'),
            'discount' => ($request->input('discount') === 0) ? null : $request->input('discount'),
            'coupons' => json_encode($coupons),
            'global_limit' => $request->input('global_limit'),
            'per_client_limit' => $request->input('per_client_limit'),
            'order' => $request->input('order'),
        ]);

        return redirect()->route('admin.plan.show', ['id' => $plan->id]);
    }
    
    public function show($id)
    {
        $plan = Plan::find($id);
        $nests = Cache::get('pterodactyl_nests');

        if (is_null($nests)) {
            $nests = $this->getPanelNests();
        } elseif ($nests === false) {
            $nests = $this->getPanelNests();
        } elseif (array_key_exists('errors', $nests)) {
            $nests = $this->getPanelNests();
        }

        $eggs = [];
        foreach ($nests['data'] as $nest) {
            foreach ($nest['attributes']['relationships']['eggs']['data'] as $egg) {
                array_push($eggs, ['id' => $egg['attributes']['id'], 'name' => $egg['attributes']['name']]);
            }
        }

        return view('admin.plan.show', ['title' => "$plan->name - Server Plans", 'header1' => 'Server Plans', 'header1_route' => 'admin.plan.index', 'header_title' => $plan->name, 'id' => $id, 'categories' => Category::orderBy('order', 'asc')->get(), 'eggs' => $eggs, 'discounts' => $this->availableDiscounts(), 'coupons' => $this->availableCoupons()]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|numeric',
            'category' => 'required|integer|gte:1',
            'egg' => 'required|integer|gte:1',
            'ram' => 'required|integer|gte:0',
            'cpu' => 'required|integer|gte:0',
            'disk' => 'required|integer|gte:0',
            'swap' => 'required|integer|gte:-1',
            'io' => 'required|integer|gte:10|lte:1000',
            'databases' => 'required|integer|gte:0',
            'backups' => 'required|integer|gte:0',
            'extra_ports' => 'required|integer|gte:0',
            'price' => 'required|numeric|gte:0',
            'setup_fee' => 'required|numeric|gte:0',
            'trial' => 'required|integer|gte:0',
            'discount' => 'required|integer|gte:0',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
        ]);

        foreach (Plan::where('name', $request->input('name'))->get() as $plan) {
            if ($plan->id != $id) {
                return back()->with('danger_msg', 'The server plan name has already been taken!');
            }
        }

        $cycles = [];
        if ($request->input('monthly')) {
            array_push($cycles, 'monthly');
        }
        if ($request->input('trimonthly')) {
            array_push($cycles, 'trimonthly');
        }
        if ($request->input('biannually')) {
            array_push($cycles, 'biannually');
        }
        if ($request->input('annually')) {
            array_push($cycles, 'annually');
        }

        $coupons = [];
        foreach ($this->availableCoupons() as $coupon) {
            if ($request->has("coupon_$coupon->code")) {
                array_push($coupons, $coupon->id);
            }
        }

        $plan = Plan::find($id);
        $plan->name = $request->input('name');
        $plan->category_id = $request->input('category');
        $plan->cpu = $request->input('cpu');
        $plan->ram = $request->input('ram');
        $plan->swap = $request->input('swap');
        $plan->disk = $request->input('disk');
        $plan->io = $request->input('io');
        $plan->databases = $request->input('databases');
        $plan->backups = $request->input('backups');
        $plan->allocations = $request->input('extra_ports') + 1;
        $plan->egg_id = $request->input('egg');
        $plan->price = $request->input('price');
        $plan->cycles = json_encode($cycles);
        $plan->setup_fee = $request->input('setup_fee');
        $plan->trial = $request->input('trial');
        $plan->discount = ($request->input('discount') === 0) ? null : $request->input('discount');
        $plan->coupons = json_encode($coupons);
        $plan->global_limit = $request->input('global_limit');
        $plan->per_client_limit = $request->input('per_client_limit');
        $plan->order = $request->input('order');
        $plan->save();

        return back()->with('success_msg', 'You have updated the server plan settings!');
    }
    
    public function delete($id)
    {
        if (Server::where('plan_id', $id)->count() > 0) {
            return back()->with('danger_msg', 'You cannot this server plan because there are servers using it!');
        }
        
        $plan = Plan::find($id);
        $plan->delete();

        return redirect()->route('admin.plan.index')->with('success_msg', 'You have deleted a server plan!');
    }

    private function getPanelNests()
    {
        $nests = $this->appApi('nests?include=eggs', 'GET');
        Cache::put('pterodactyl_nests', $nests, now()->addMinutes(15));
        return $nests;
    }
}
