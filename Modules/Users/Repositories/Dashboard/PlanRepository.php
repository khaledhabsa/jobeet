<?php

namespace Modules\Users\Repositories\Dashboard;

use Modules\Users\Entities\Plan;

class PlanRepository {
    protected $stripe;
    protected $model;
    public function __construct(Plan $Plan)
    {
        $this->model = $Plan;
    }
    public function store($request){
        // local plan
        $plan = new Plan();
        $plan->name = $request['name'];
        $plan->en_name = $request['en_name'];
        $plan->price = $request['price'];
        $plan->months = $request['months'];
        $plan->prod_id = $request['prod_id'];
        $plan->save();

        return $plan;
    }

    public function update($request, $plan){
        $plan->name = $request['name'] ?? $plan->name;
        $plan->en_name = $request['en_name'] ?? $plan->en_name;
        $plan->price = $request['price'] ?? $plan->price;
        $plan->months = $request['months'] ?? $plan->months;
        $plan->save();

        return $plan;
    }

    public function destroy($plan){
        return $plan->delete($plan);
    }
}
