<?php

namespace App\Http\Controllers\Public;

use App\Models\Field;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function store(Request $request, Field $field)
    {
        $user = $request->user();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $hasCompletedReservation = Reservation::where('user_id', $user->id)
            ->where('field_id', $field->id)
            ->where('status', 'completed')
            ->exists();

        if (! $hasCompletedReservation) {
            return back()->with('review_error', 'You can only review fields where you have a completed reservation.');
        }

        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('field_id', $field->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('review_error', 'You already posted a review for this field.');
        }

        Review::create([
            'user_id' => $user->id,
            'field_id' => $field->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('review_success', 'Your review has been added successfully.');
    }

    public function update(Request $request, Field $field, Review $review)
    {
        $user = $request->user();

        if ($review->field_id !== $field->id) {
            return back()->with('review_error', 'Invalid review target.');
        }

        if ($review->user_id !== $user->id) {
            return back()->with('review_error', 'You can only edit your own review.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('review_success', 'Your review has been updated successfully.');
    }

    public function destroy(Request $request, Field $field, Review $review)
    {
        $user = $request->user();

        if ($review->field_id !== $field->id) {
            return back()->with('review_error', 'Invalid review target.');
        }

        if ($review->user_id !== $user->id) {
            return back()->with('review_error', 'You can only delete your own review.');
        }

        $review->delete();

        return back()->with('review_success', 'Your review has been deleted successfully.');
    }
}
