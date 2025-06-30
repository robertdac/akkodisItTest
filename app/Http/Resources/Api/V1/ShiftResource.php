<?php

    namespace App\Http\Resources\Api\V1;

    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Database\Eloquent\Collection;

    class ShiftResource extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @return array<string, mixed>
         */
        public function toArray(Request $request): array
        {


            if ($this->resource instanceof Collection) {

                $data = [];
                foreach ($this->resource as $shift) {

                    $start = Carbon::parse($shift->start_date);
                    $end = Carbon::parse($shift->end_date);
                    $data[] = [
                        'type' => ucfirst($shift->type),
                        'start_date' => $start->format('d/m/Y H:i'),
                        'end_date' => $end->format('d/m/Y H:i'),
                        'days' => $start->diffInDays($end) + 1,
                        'hours' => $start->diffInHours($end),
                    ];

                }

                return $data;
            }

            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);

            return [
                'type' => ucfirst($this->type),
                'start_date' => $start->format('d/m/Y H:i'),
                'end_date' => $end->format('d/m/Y H:i'),
                'days' => $start->diffInDays($end) + 1,
                'hours' => $start->diffInHours($end),
            ];


        }
    }
