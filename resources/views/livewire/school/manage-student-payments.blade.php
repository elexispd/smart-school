<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Student Payments</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Record and track student fee payments</p>
            </div>
            <button wire:click="create" wire:loading.attr="disabled" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 disabled:opacity-50">
                <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <svg wire:loading class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Record Payment
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('message') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Total Collected</p>
                        <h3 class="text-3xl font-bold mt-2">₦{{ number_format($stats['total_collected'], 2) }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Today's Collection</p>
                        <h3 class="text-3xl font-bold mt-2">₦{{ number_format($stats['today_collected'], 2) }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Transactions</p>
                        <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['total_payments']) }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <input wire:model.live="search" type="text" placeholder="Search by name or admission number..." class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                <button wire:click="openFilterModal" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Advanced Filter
                </button>
                @if($reportFeeStructure || $reportClass || $reportStatus || $reportDateFrom)
                <button wire:click="clearFilters" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">
                    Clear Filters
                </button>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <div class="bg-white dark:bg-gray-800 sm:rounded-xl shadow-sm border-0 sm:border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">S/N</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Class</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Session/Term</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Fee Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Installment</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Date</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($payments as $index => $payment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ is_object($payments) && method_exists($payments, 'firstItem') ? $payments->firstItem() + $index : $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold">
                                            {{ substr(is_object($payment) && isset($payment->student) ? $payment->student->user->name : $payment->student_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ is_object($payment) && isset($payment->student) ? $payment->student->user->name : $payment->student_name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ is_object($payment) && isset($payment->student) ? $payment->student->admission_number : $payment->admission_number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ is_object($payment) && isset($payment->student) ? $payment->student->currentClass->name . ($payment->student->classArm ? ' - ' . $payment->student->classArm->name : '') : $payment->class_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ is_object($payment) && isset($payment->feeStructure) ? $payment->feeStructure->session->name . ($payment->feeStructure->term ? ' - ' . ucfirst($payment->feeStructure->term) : '') : '-' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ is_object($payment) && isset($payment->feeStructure) ? $payment->feeStructure->feeCategory->name : $payment->fee_category }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    @if(is_object($payment) && isset($payment->feeInstallment))
                                        {{ $payment->feeInstallment->name }}
                                    @elseif(isset($payment->status))
                                        @if($payment->status === 'Paid')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Completed</span>
                                        @elseif($payment->status === 'Partial')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-700">Partial (₦{{ number_format($payment->balance, 2) }} left)</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Not Paid</span>
                                        @endif
                                    @else
                                        @php
                                            $totalPaid = \App\Models\StudentPayment::where('student_id', $payment->student_id)
                                                ->where('fee_structure_id', $payment->fee_structure_id)
                                                ->sum('amount');
                                            $isFullyPaid = $totalPaid >= $payment->feeStructure->amount;
                                        @endphp
                                        @if($isFullyPaid)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Completed</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-700">Partial (₦{{ number_format($payment->feeStructure->amount - $totalPaid, 2) }} left)</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-emerald-600">₦{{ number_format(is_object($payment) && isset($payment->amount) ? $payment->amount : $payment->amount_paid, 2) }}</td>
                                <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">{{ is_object($payment) && isset($payment->payment_method) ? ucfirst(str_replace('_', ' ', $payment->payment_method)) : '-' }}</span></td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ is_object($payment) && isset($payment->payment_date) ? $payment->payment_date->format('M d, Y') : ($payment->last_payment_date ? $payment->last_payment_date->format('M d, Y') : 'N/A') }}</td>
                                <td class="px-6 py-4 text-right">
                                    @if(is_object($payment) && isset($payment->id))
                                    <button wire:click="delete('{{ $payment->id }}')" class="px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg text-sm hover:bg-red-100">Delete</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="px-6 py-12 text-center text-gray-500">No payments recorded yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-6">{{ $payments->links() }}</div>
    </div>

    @if($showStudentSearchModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Search Student</h3>
                    <div class="mb-4">
                        <input wire:model.live="studentSearch" type="text" placeholder="Search by name, admission number, or class..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white" autofocus>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @if(count($searchResults) > 0)
                        <div class="space-y-2">
                            @foreach($searchResults as $student)
                            <button wire:click="selectStudent('{{ $student->id }}')" class="w-full flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-lg transition-colors text-left">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr($student->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $student->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->admission_number }} • {{ $student->currentClass->name }}{{ $student->classArm ? ' - ' . $student->classArm->name : '' }}</p>
                                </div>
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                            @endforeach
                        </div>
                        @elseif(strlen($studentSearch) >= 2)
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No students found</p>
                        @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Type at least 2 characters to search</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        <button wire:click="closeModal" class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    @if($showModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Record Payment</h3>
                    
                    @if($selectedStudentInfo)
                    <div class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($selectedStudentInfo->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $selectedStudentInfo->user->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $selectedStudentInfo->admission_number }} • {{ $selectedStudentInfo->currentClass->name }}{{ $selectedStudentInfo->classArm ? ' - ' . $selectedStudentInfo->classArm->name : '' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fee Schedule *</label>
                            <select wire:model.live="fee_structure_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Fee Schedule</option>
                                @foreach($feeStructures as $structure)
                                <option value="{{ $structure->id }}">{{ $structure->feeCategory->name }} - {{ $structure->session->name }}{{ $structure->term ? ' (' . ucfirst($structure->term) . ' Term)' : '' }} - ₦{{ number_format($structure->amount, 2) }}</option>
                                @endforeach
                            </select>
                            @error('fee_structure_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if($selectedFeeStructure)
                        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Total Fee</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">₦{{ number_format($selectedFeeStructure->amount, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Paid</p>
                                    <p class="text-lg font-bold text-green-600">₦{{ number_format($totalPaid, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Balance</p>
                                    <p class="text-lg font-bold text-orange-600">₦{{ number_format($remainingBalance, 2) }}</p>
                                </div>
                            </div>
                            @if($selectedFeeStructure->payment_type === 'installment')
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 text-center">✓ Installment payment - Select which installment to pay</p>
                            @else
                            <p class="text-xs text-orange-600 dark:text-orange-400 mt-2 text-center">⚠ One-time payment - Must pay exact amount</p>
                            @endif
                        </div>
                        @endif

                        @if($fee_structure_id && count($installments) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Installment *</label>
                            <select wire:model.live="fee_installment_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Installment</option>
                                @foreach($installments as $installment)
                                <option value="{{ $installment->id }}">{{ $installment->name }} ({{ $installment->percentage }}% - ₦{{ number_format(($selectedFeeStructure->amount * $installment->percentage) / 100, 2) }})@if($installment->due_date) - Due: {{ $installment->due_date->format('M d, Y') }}@endif</option>
                                @endforeach
                            </select>
                            @if(count($installments) === 0)
                            <p class="text-xs text-green-600 mt-1">✓ All installments have been paid</p>
                            @endif
                            @error('fee_installment_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount *</label>
                                <input wire:model="amount" type="number" step="0.01" readonly class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Date *</label>
                                <input wire:model="payment_date" type="date" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                @error('payment_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method *</label>
                            <select wire:model="payment_method" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="card">Card</option>
                                <option value="cheque">Cheque</option>
                                <option value="online">Online</option>
                            </select>
                            @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reference Number</label>
                            <input wire:model="reference_number" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('reference_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Remarks</label>
                            <textarea wire:model="remarks" rows="3" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white"></textarea>
                            @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button wire:click="closeModal" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">Cancel</button>
                        <button wire:click="save" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove>Save Payment</span>
                            <svg wire:loading class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Delete Payment?</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button wire:click="closeModal" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">Cancel</button>
                        <button wire:click="confirmDelete" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove>Delete</span>
                            <svg wire:loading class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    @if($showFilterModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Payment Report Filters</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fee Schedule</label>
                            <select wire:model="reportFeeStructure" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">All Fee Schedules</option>
                                @foreach($allFeeStructures as $structure)
                                <option value="{{ $structure->id }}">{{ $structure->feeCategory->name }} - ₦{{ number_format($structure->amount, 2) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Status</label>
                            <select wire:model="reportStatus" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">All Status</option>
                                <option value="Paid">Fully Paid</option>
                                <option value="Partial">Partially Paid</option>
                                <option value="Unpaid">Not Paid</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class</label>
                            <select wire:model.live="reportClass" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($reportClass && $reportClassArms->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class Arm</label>
                            <select wire:model="reportClassArm" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">All Arms</option>
                                @foreach($reportClassArms as $arm)
                                <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date From</label>
                            <input wire:model="reportDateFrom" type="date" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date To</label>
                            <input wire:model="reportDateTo" type="date" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="closeModal" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">Cancel</button>
                        <button wire:click="applyFilters" wire:loading.attr="disabled" wire:target="applyFilters" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="applyFilters">Apply Filters</span>
                            <svg wire:loading wire:target="applyFilters" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                        <button wire:click="exportReport" wire:loading.attr="disabled" wire:target="exportReport" class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="exportReport" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Export Excel
                            </span>
                            <svg wire:loading wire:target="exportReport" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif
</div>
