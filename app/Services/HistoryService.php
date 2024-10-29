<?php

namespace App\Services;

use App\Models\History;

class HistoryService
{
    /**
     * Record the changes of a model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $original
     * @param array $changes
     * @return void
     */
    public static function record($model, $original, $changes)
    {
        foreach ($changes as $field => $newValue) {
            $oldValue = $original[$field] ?? 'not_exists';

            // Record the change in the history table
            History::create([
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'field' => $field,
                'old_value' => (string)$oldValue,
                'new_value' => (string)$newValue,
                'user_id' => auth()->id() ?? 1, // Default to 1 if no user is authenticated
            ]);
        }
    }
}
