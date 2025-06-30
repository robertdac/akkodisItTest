<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Shift extends Model
    {
        use HasFactory;

        protected $fillable = [
            'employee_id',
            'type',
            'start_date',
            'end_date',
        ];

        public function employee(): BelongsTo
        {
            return $this->belongsTo(Employee::class);
        }


        public function scopeWithinDateRange($query, $start, $end)
        {
            return $query->where(function($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                    });
            });
        }

        public function scopeOnlyWork($query)
        {
            return $query->where('type', 'work');
        }


    }
