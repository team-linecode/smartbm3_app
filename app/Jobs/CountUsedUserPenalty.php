<?php

namespace App\Jobs;

use App\Models\PenaltyPoint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CountUsedUserPenalty implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $data;

    public function __construct(array $request)
    {
        $this->data = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (isset($this->data) && !empty($this->data)) {
            $penalty_point = PenaltyPoint::find($this->data['penalty_point_id']);

            if ($this->data['times'] < 1) {
                $this->data['times'] = 1;
            }

            if ($this->data['type'] == 'plus') {
                $penalty_point->used = ($penalty_point->used + $this->data['times']);
            } else if ($this->data['type'] == 'minus') {
                $penalty_point->used = ($penalty_point->used - $this->data['times']);
            }

            $penalty_point->update();
        }
    }
}
