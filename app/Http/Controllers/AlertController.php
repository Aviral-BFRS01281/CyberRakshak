<?php

namespace App\Http\Controllers;

use App\Http\Resources\Internal\Alerts\AlertCollection;
use App\Http\Resources\Internal\Alerts\AlertResource;
use App\Http\Resources\NullResource;
use App\Models\Alert;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlertController extends APIController
{
    public function index() : AlertCollection
    {
        return new AlertCollection(Alert::query()
            ->with("user")
            ->where("created_at", ">", now()->subDays(2)->startOfDay())
            ->where("action_taken", 0)
            ->paginate()
        );
    }

    public function show(int $id) : JsonResponse|NullResource|AlertResource
    {
        $alert = Alert::query()->with("user")->find($id);

        if ($alert == null)
        {
            return new NullResource("alert");
        }
        else
        {
            $alert->update([
                "viewed" => 1
            ]);

            return new AlertResource($alert);
        }
    }

    public function update(int $id, Request $request) : JsonResponse|NullResource
    {
        $alert = Alert::query()->find($id);

        if ($alert == null)
        {
            return new NullResource("alert");
        }

        match ($request->action)
        {
            "limit" => $this->limit(),
            "block" => $this->block(),
            "blacklist" => $this->blacklist(),
        };

        $alert->update([
            "action_taken" => 1
        ]);

        return $this->respondWithOkay([
            "message" => "Action was taken successfully."
        ]);
    }

    protected function limit() : void
    {

    }

    protected function block() : void
    {

    }

    protected function blacklist() : void
    {

    }
}
