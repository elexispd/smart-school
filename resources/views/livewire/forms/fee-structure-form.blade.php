<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">{{ $structureId ? 'Edit' : 'Create' }} Fee Structure</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Fee Category *</label>
                <select wire:model="fee_category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('fee_category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Session *</label>
                <select wire:model="session_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select Session</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                    @endforeach
                </select>
                @error('session_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Class</label>
                <select wire:model.live="class_id" class="w-full border rounded px-3 py-2">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
                @error('class_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Class Arm</label>
                <select wire:model="class_arm_id" class="w-full border rounded px-3 py-2" {{ !$class_id ? 'disabled' : '' }}>
                    <option value="">All Arms</option>
                    @foreach($classArms as $arm)
                        <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                    @endforeach
                </select>
                @error('class_arm_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Amount *</label>
                <input type="number" step="0.01" wire:model="amount" class="w-full border rounded px-3 py-2" required>
                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Payment Type *</label>
                <select wire:model.live="payment_type" class="w-full border rounded px-3 py-2" required>
                    <option value="one_time">One Time</option>
                    <option value="installment">Installment</option>
                </select>
                @error('payment_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex items-center">
            <input type="checkbox" wire:model="is_active" class="mr-2">
            <label class="text-sm font-medium">Active</label>
        </div>

        @if($payment_type === 'installment')
            <div class="border-t pt-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Installments</h3>
                    <button type="button" wire:click="addInstallment" class="bg-green-600 text-white px-3 py-1 rounded text-sm">+ Add</button>
                </div>

                @foreach($installments as $index => $installment)
                    <div class="grid grid-cols-4 gap-2 mb-2 items-start">
                        <div>
                            <input type="text" wire:model="installments.{{ $index }}.name" placeholder="Name" class="w-full border rounded px-2 py-1 text-sm" required>
                            @error("installments.$index.name") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="number" step="0.01" wire:model="installments.{{ $index }}.percentage" placeholder="%" class="w-full border rounded px-2 py-1 text-sm" required>
                            @error("installments.$index.percentage") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="date" wire:model="installments.{{ $index }}.due_date" class="w-full border rounded px-2 py-1 text-sm">
                            @error("installments.$index.due_date") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <button type="button" wire:click="removeInstallment({{ $index }})" class="bg-red-600 text-white px-2 py-1 rounded text-sm">Remove</button>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
            <a href="{{ route('fee-structures.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>
