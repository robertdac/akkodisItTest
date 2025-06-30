<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\Api\V1\ShiftRequest;
    use App\Models\User;
    use Carbon\Carbon;
    use App\Http\Resources\Api\V1\ShiftResource;

    class ShiftAssignmentController extends Controller
    {

        public function show(ShiftRequest $request, User $user): ShiftResource
        {

            $shiftsQuery = $user->employee->shifts();
            $shifts = $shiftsQuery->withinDateRange($request->query('start'), $request->query('end'));


            if ($request->boolean('fuel')) {
                $shifts->onlyWork();
            }

            if ($request->boolean('first')) {
                $shift = $shifts->orderBy('id', 'asc')->limit(1)->first();
                return new ShiftResource($shift);
            }

            if ($request->boolean('last')) {
                $shift = $shifts->orderBy('id', 'desc')->limit(1)->first();
                return new ShiftResource($shift);
            }


            $shifts = $shifts->orderBy('start_date')->get();
            return new ShiftResource($shifts);

        }


    }
