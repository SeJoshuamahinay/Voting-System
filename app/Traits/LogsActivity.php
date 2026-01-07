<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Log an activity.
     */
    protected function logActivity($description, $event, $subjectType = null, $subjectId = null, array $properties = [])
    {
        return ActivityLog::log($description, $event, $subjectType, $subjectId, $properties);
    }

    /**
     * Log a creation event.
     */
    protected function logCreated($model, $description = null)
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} was created by " . auth()->user()->name;
        
        return $this->logActivity(
            $description,
            'created',
            get_class($model),
            $model->id
        );
    }

    /**
     * Log an update event.
     */
    protected function logUpdated($model, $description = null, array $changes = [])
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} was updated by " . auth()->user()->name;
        
        return $this->logActivity(
            $description,
            'updated',
            get_class($model),
            $model->id,
            $changes
        );
    }

    /**
     * Log a deletion event.
     */
    protected function logDeleted($modelClass, $modelId, $description = null)
    {
        $modelName = class_basename($modelClass);
        $description = $description ?? "{$modelName} was deleted by " . auth()->user()->name;
        
        return $this->logActivity(
            $description,
            'deleted',
            $modelClass,
            $modelId
        );
    }
}
