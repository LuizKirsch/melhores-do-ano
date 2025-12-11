<?php

namespace App\Livewire;

use App\Models\Alternative;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboard extends Component
{
    protected $layout = 'components.layouts.app';

    public function render()
    {
        $activeAlternative = Alternative::with(['options', 'votes'])
            ->where('active', true)
            ->first();

        $userVote = null;
        $hasVoted = false;

        if ($activeAlternative) {
            $hasVoted = Auth::user()->hasVotedFor($activeAlternative->id);
            if ($hasVoted) {
                $userVote = Vote::where('user_id', Auth::id())
                    ->where('alternative_id', $activeAlternative->id)
                    ->with('option')
                    ->first();
            }
        }

        return view('livewire.user-dashboard', [
            'activeAlternative' => $activeAlternative,
            'hasVoted' => $hasVoted,
            'userVote' => $userVote
        ]);
    }
}
