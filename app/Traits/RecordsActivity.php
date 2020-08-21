<?php

namespace App\Traits;

use ReflectionClass;
use App\Models\Activity;
use Illuminate\Support\Str;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::events() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

    }

    public static function events()
    {
        return ['created', 'updated'];
    }

    public function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event)
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getActivityType($event)
    {
        $modelName = Str::lower((new ReflectionClass($this))->getShortName());

        return "{$event}_{$modelName}";
    }
}
