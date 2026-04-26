<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\User;
use Spatie\Permission\Models\Role;

new class extends Component {
    public string $search = '';

    #[Computed]
    public function users()
    {
    $auth = Auth::user();

    return User::query()

        ->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        })

        ->when(!$auth->hasRole('super_admin'), function ($query) use ($auth) {

            $query->whereHas('roles', function ($q) {
                $q->where('name', 'field_guard');
            })

            ->whereHas('guardedFields', function ($q) use ($auth) {
                $q->where('fields.user_id', $auth->id);
            });

        })

        ->with('roles')
        ->latest()
        ->get();
    }

    #[Computed]
    public function roles()
    {
        return Role::query()
            ->orderBy('name')
            ->get();
    }

    public function updateStatus(int $userId, string $status): void
    {
        if (!in_array($status, ['active', 'inactive'], true)) {
            return;
        }

        $user = User::find($userId);

        if (!$user) {
            return;
        }

        $user->update(['status' => $status]);
    }

    public function updateRole(int $userId, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return;
        }

        $user = User::find($userId);

        if (!$user) {
            return;
        }

        $user->syncRoles([$role->name]);
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
                placeholder="Search users by name..."
                class="pl-10 pr-4 h-10 w-full rounded-xl bg-gray-50 border border-transparent focus:bg-white focus:border-green-500 outline-none"
            >
        </div>

        <div class="flex items-center gap-3">
            <button class="rounded-xl h-10 border border-gray-200 text-gray-600 bg-white shadow-sm gap-2 px-4 inline-flex items-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18M6.75 12h10.5M10.5 19.5h3"/>
                </svg>
                <span>Filters</span>
            </button>

            <button class="rounded-xl h-10 border border-gray-200 text-gray-600 bg-white shadow-sm px-4 inline-flex items-center">
                Export
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left whitespace-nowrap">
            <thead class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">ID</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold">Role</th>
                    <th class="px-6 py-4 font-semibold">Date Created</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                @forelse ($this->users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-500">#{{ $user->id }}</td>

                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-gray-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10.2A6 6 0 1118 10.8C18 16.65 12 21 12 21z"/>
                                    <circle cx="12" cy="10.5" r="2.25"/>
                                </svg>
                                <span>{{ $user->email }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-3">
                                <select
                                    class="h-9 rounded-lg border border-gray-200 bg-white text-xs text-gray-700 px-2"
                                    wire:change="updateStatus({{ $user->id }}, $event.target.value)"
                                >
                                    <option value="active" @selected($user->status === 'active')>Active</option>
                                    <option value="inactive" @selected($user->status === 'inactive')>Inactive</option>
                                </select>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-3">
                                <select
                                    class="h-9 rounded-lg border border-gray-200 bg-white text-xs text-gray-700 px-2"
                                    wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                >   
                                    @role('super_admin')
                                    @foreach ($this->roles as $role)
                                        <option value="{{ $role->name }}" @selected($user->roles->first()?->name === $role->name)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                    @endrole
                                    @role('field_manager')
                                        <option value="field_guard" @selected($user->roles->first()?->name === 'field_guard')>
                                            field_guard
                                        </option>
                                    @endrole
                                </select>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $user->created_at?->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit User</span>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors inline-flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-10.5 0V6a1.5 1.5 0 011.5-1.5h6A1.5 1.5 0 0116.5 6v1.5m-9 0v10.125A1.875 1.875 0 009.375 19.5h5.25A1.875 1.875 0 0016.5 17.625V7.5"/>
                                        </svg>
                                        <span>Delete User</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 sm:p-6 border-t border-gray-100 bg-gray-50/30">
        <span class="text-sm text-gray-500 font-medium">
            Results: {{ $this->users->count() }}
        </span>
    </div>
</div>