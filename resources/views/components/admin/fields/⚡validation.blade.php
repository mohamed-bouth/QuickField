<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Field;

new class extends Component {
    public string $search = '';

    #[Computed]
    public function pendingFields()
    {
        return Field::query()
            ->with('user')
            ->where('status', 'pending')
            ->when($this->search, function ($query) {
                $query->where(function ($nested) {
                    $nested->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('localisation', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->get();
    }

    public function validateField(int $fieldId, string $status): void
    {
        if (!in_array($status, ['active', 'rejected'], true)) {
            return;
        }

        $field = Field::query()
            ->where('status', 'pending')
            ->find($fieldId);

        if (!$field) {
            return;
        }

        $field->update([
            'status' => $status,
        ]);

        session()->flash('validation_success', 'Field #' . $field->id . ' has been marked as ' . $status . '.');
    }
};
?>

<div class="border-0 shadow-sm rounded-2xl bg-white overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between gap-4 bg-white">
        <div class="relative w-full max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search pending fields..."
                class="pl-10 pr-4 h-10 w-full rounded-xl bg-gray-50 border border-transparent focus:bg-white focus:border-green-500 outline-none"
            >
        </div>

        <div class="text-sm text-gray-500 inline-flex items-center">
            Pending fields: {{ $this->pendingFields->count() }}
        </div>
    </div>

    @if (session('validation_success'))
        <div class="mx-4 mt-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
            {{ session('validation_success') }}
        </div>
    @endif

    <div class="overflow-x-auto mt-4 sm:mt-0">
        <table class="w-full text-sm text-left whitespace-nowrap">
            <thead class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">ID</th>
                    <th class="px-6 py-4 font-semibold">Field Information</th>
                    <th class="px-6 py-4 font-semibold">Manager</th>
                    <th class="px-6 py-4 font-semibold">Submitted</th>
                    <th class="px-6 py-4 font-semibold text-right">Validation Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                @forelse ($this->pendingFields as $field)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-500">#{{ $field->id }}</td>

                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $field->name }}</div>
                            <div class="text-gray-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10.2A6 6 0 1118 10.8C18 16.65 12 21 12 21z"/>
                                    <circle cx="12" cy="10.5" r="2.25"/>
                                </svg>
                                <span>{{ $field->localisation }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $field->user?->name ?? 'Unknown Manager' }}
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $field->created_at?->format('M d, Y H:i') }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.fields.show', $field->id) }}"
                                   class="px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 4.5 20.25l.787-3.75L16.862 4.487z"/>
                                    </svg>
                                    <span>show Details</span>
                            </a>
                                <button
                                    type="button"
                                    wire:click="validateField({{ $field->id }}, 'active')"
                                    class="px-3 py-2 rounded-lg text-sm text-green-600 hover:bg-green-100 hover:text-green-900 transition-colors inline-flex items-center gap-2"
                                >
                                    <span>Activate</span>
                                </button>

                                <button
                                    type="button"
                                    wire:click="validateField({{ $field->id }}, 'rejected')"
                                    class="px-3 py-2 rounded-lg text-sm text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors inline-flex items-center gap-2"
                                >
                                    <span>Reject</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No pending fields to validate.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
