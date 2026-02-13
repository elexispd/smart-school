<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Fee Schedules</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure fees for classes and sessions</p>
            </div>
            <button wire:click="create" wire:loading.attr="disabled" wire:target="create" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 text-white font-semibold rounded-lg transition-colors flex items-center gap-2">
                <svg wire:loading.remove wire:target="create" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <svg wire:loading wire:target="create" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Add Schedule
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <input wire:model.live="search" type="text" placeholder="Search by category..." class="flex-1 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
            <div class="flex gap-2">
                <button wire:click="$set('viewMode', 'grid')" class="flex-1 sm:flex-none px-4 py-2.5 {{ $viewMode === 'grid' ? 'bg-emerald-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} border border-gray-300 dark:border-gray-600 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="hidden sm:inline">Grid</span>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="flex-1 sm:flex-none px-4 py-2.5 {{ $viewMode === 'table' ? 'bg-emerald-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} border border-gray-300 dark:border-gray-600 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span class="hidden sm:inline">Table</span>
                </button>
            </div>
        </div>

        @if($viewMode === 'grid')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($structures as $structure)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $structure->feeCategory->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $structure->session->name }}{{ $structure->term ? ' - ' . ucfirst($structure->term) . ' Term' : '' }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $structure->schoolClass?->name ?? 'All Classes' }}{{ $structure->classArm ? ' - ' . $structure->classArm->name : '' }}</p>
                    <p class="text-lg font-bold text-emerald-600 mt-2">₦{{ number_format($structure->amount, 2) }}</p>
                    <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700">{{ ucfirst(str_replace('_', ' ', $structure->payment_type)) }}</span>
                </div>
                <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    @if($structure->canModify)
                    <button wire:click="toggleStatus('{{ $structure->id }}')" wire:loading.attr="disabled" class="flex-1 px-3 py-2 {{ $structure->is_active ? 'bg-gray-50 hover:bg-gray-100 text-gray-600' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-600' }} font-medium rounded-lg text-sm disabled:opacity-50">
                        <span wire:loading.remove>{{ $structure->is_active ? 'Disable' : 'Enable' }}</span>
                        <svg wire:loading class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                    <button wire:click="edit('{{ $structure->id }}')" wire:loading.attr="disabled" class="flex-1 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium rounded-lg text-sm disabled:opacity-50">
                        <span wire:loading.remove>Edit</span>
                        <svg wire:loading class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 718-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                    <button wire:click="delete('{{ $structure->id }}')" wire:loading.attr="disabled" class="flex-1 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-medium rounded-lg text-sm disabled:opacity-50">
                        <span wire:loading.remove>Delete</span>
                        <svg wire:loading class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 718-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                    @else
                    <div class="flex-1 px-3 py-2 bg-gray-100 text-gray-400 font-medium rounded-lg text-sm text-center">Past Term/Session</div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12"><p class="text-gray-500">No fee schedules found</p></div>
            @endforelse
        </div>
        @else
        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <div class="bg-white dark:bg-gray-800 sm:rounded-xl shadow-sm border-0 sm:border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">S/N</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Session</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Term</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Class/Arm</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($structures as $index => $structure)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $structures->firstItem() + $index }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $structure->feeCategory->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $structure->session->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $structure->term ? ucfirst($structure->term) : 'All' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $structure->schoolClass?->name ?? 'All' }}{{ $structure->classArm ? ' - ' . $structure->classArm->name : '' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-emerald-600">₦{{ number_format($structure->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $structure->payment_type)) }}</td>
                                <td class="px-6 py-4"><span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $structure->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $structure->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td class="px-6 py-4 text-right">
                                    @if($structure->canModify)
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="toggleStatus('{{ $structure->id }}')" wire:loading.attr="disabled" class="px-3 py-1.5 {{ $structure->is_active ? 'bg-gray-50 text-gray-600' : 'bg-emerald-50 text-emerald-600' }} font-medium rounded-lg text-sm disabled:opacity-50">
                                            <span wire:loading.remove>{{ $structure->is_active ? 'Disable' : 'Enable' }}</span>
                                            <svg wire:loading class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 718-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </button>
                                        <button wire:click="edit('{{ $structure->id }}')" wire:loading.attr="disabled" class="px-3 py-1.5 bg-blue-50 text-blue-600 font-medium rounded-lg text-sm disabled:opacity-50">
                                            <span wire:loading.remove>Edit</span>
                                            <svg wire:loading class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 718-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </button>
                                        <button wire:click="delete('{{ $structure->id }}')" wire:loading.attr="disabled" class="px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg text-sm disabled:opacity-50">
                                            <span wire:loading.remove>Delete</span>
                                            <svg wire:loading class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 718-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </button>
                                    </div>
                                    @else
                                    <span class="text-gray-400 text-sm">Past Term/Session</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="px-6 py-12 text-center text-gray-500">No fee schedules found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6">{{ $structures->links() }}</div>
    </div>

    @if($showModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $isEdit ? 'Edit' : 'Add' }} Fee Schedule</h3>

                    @if (session()->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">{{ session('error') }}</div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fee Category *</label>
                            <select wire:model="fee_category_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('fee_category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Session *</label>
                            <select wire:model="session_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Session</option>
                                @foreach($sessions as $session)
                                <option value="{{ $session->id }}">{{ $session->name }}</option>
                                @endforeach
                            </select>
                            @error('session_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Term</label>
                            <select wire:model="term" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">All Terms</option>
                                <option value="first">First Term</option>
                                <option value="second">Second Term</option>
                                <option value="third">Third Term</option>
                            </select>
                            @error('term') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model.live="is_general" type="checkbox" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Apply to all classes</span>
                            </label>
                        </div>
                        @if(!$is_general)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class *</label>
                            <select wire:model.live="class_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @if($class_id && count($classArms) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class Arm (Optional)</label>
                            <select wire:model="class_arm_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">All Arms</option>
                                @foreach($classArms as $arm)
                                <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                                @endforeach
                            </select>
                            @error('class_arm_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount *</label>
                            <input wire:model="amount" type="number" step="0.01" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Type *</label>
                            <select wire:model.live="payment_type" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="one_time">One Time</option>
                                <option value="installment">Installment</option>
                            </select>
                            @error('payment_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @if($payment_type === 'installment')
                        <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Installments</label>
                                    <p class="text-xs text-gray-500 mt-0.5">Split payment into parts (e.g., 1st: 50%, 2nd: 50%)</p>
                                </div>
                                <button wire:click="addInstallment" type="button" class="px-3 py-1 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700">+ Add</button>
                            </div>
                            @foreach($installments as $index => $installment)
                            <div class="flex gap-2 mb-2">
                                <input wire:model="installments.{{ $index }}.name" type="text" placeholder="Name (e.g., 1st Installment)" class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:text-white">
                                <input wire:model="installments.{{ $index }}.percentage" type="number" placeholder="%" class="w-20 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:text-white">
                                <input wire:model="installments.{{ $index }}.due_date" type="date" class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:text-white">
                                <button wire:click="removeInstallment({{ $index }})" type="button" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm hover:bg-red-100">×</button>
                            </div>
                            @error('installments.' . $index . '.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @error('installments.' . $index . '.percentage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @endforeach
                            <p class="text-xs text-gray-500 mt-2">Total: {{ array_sum(array_column($installments, 'percentage')) }}% (must equal 100%)</p>
                        </div>
                        @endif
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model="is_active" type="checkbox" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button wire:click="closeModal" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors disabled:opacity-50">Cancel</button>
                        <button wire:click="save" wire:loading.attr="disabled" wire:target="save" class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="save">Save</span>
                            <svg wire:loading wire:target="save" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    @if($showDeleteModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                        <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Delete Fee Schedule?</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button wire:click="closeModal" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors disabled:opacity-50">Cancel</button>
                        <button wire:click="confirmDelete" wire:loading.attr="disabled" wire:target="confirmDelete" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="confirmDelete">Delete</span>
                            <svg wire:loading wire:target="confirmDelete" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif
</div>
