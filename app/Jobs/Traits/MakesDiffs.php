<?php

namespace App\Jobs\Traits;

use App\Diff;

trait MakesDiffs
{
    use CallsTwitter;

    protected function makeDiffFor(string $for) : void
    {
        $ids = $this->getIdsFor($for);

        if ($this->user->{$for}->isNotEmpty()) {
            $additions = array_diff($ids, $this->user->{$for}->toArray());
            $deletions = array_diff($this->user->{$for}->toArray(), $ids);

            if (! count($additions) && ! count($deletions)) {
                return;
            }

            $this->user->diffs()->save(
                new Diff($attributes = [
                    'for'       => $for,
                    'additions' => $additions = $this->getUsersDetailsForIds($additions),
                    'deletions' => $deletions = $this->getUsersDetailsForIds($deletions),
                ])
            );
        }

        // We save the IDs when we are sure all the code above ran successfully.
        // That way, the next job will still be able to detected IDs that
        // changed at the time the failed job ran.
        $this->user->update([$for => $ids]);
    }
}
