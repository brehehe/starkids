<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <flux:heading size="xl">Pengajuan Ijin & Cuti</flux:heading>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 lg:col-span-1">
            <flux:heading size="lg" class="mb-4">Buat Pengajuan Baru</flux:heading>
            
            <form wire:submit.prevent="submitLeave" class="space-y-4">
                
                <flux:select wire:model="type" label="Jenis Pengajuan">
                    <option value="annual">Cuti Tahunan</option>
                    <option value="sick">Sakit</option>
                    <option value="permission">Ijin Khusus</option>
                </flux:select>
                
                <div class="grid grid-cols-2 gap-4">
                    <flux:input wire:model="start_date" type="date" label="Mulai Tanggal" required />
                    <flux:input wire:model="end_date" type="date" label="Sampai Tanggal" required />
                </div>
                
                <flux:textarea wire:model="reason" label="Alasan / Keterangan" rows="3" required></flux:textarea>
                
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700">Lampiran Bukti (Opsional)</label>
                    <input type="file" wire:model="attachment" class="w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded file:border-0
                        file:text-sm file:font-semibold
                        file:bg-emerald-50 file:text-emerald-700
                        hover:file:bg-emerald-100 border p-2 rounded"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <div wire:loading wire:target="attachment" class="text-xs text-blue-500 mt-1">Mengunggah...</div>
                    @error('attachment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <flux:button type="submit" variant="primary" color="blue" class="w-full" wire:loading.attr="disabled">
                    Kirim Pengajuan
                </flux:button>
            </form>
        </div>

        <!-- History Section -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 lg:col-span-2">
            <flux:heading size="lg" class="mb-4">Riwayat Pengajuan</flux:heading>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 bg-gray-50 uppercase border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3">Tanggal Pengajuan</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3">Tgl Mulai - Selesai</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500">{{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 font-medium">
                                @if($leave->type == 'annual') Cuti Tahunan 
                                @elseif($leave->type == 'sick') Sakit 
                                @else Ijin Khusus @endif
                            </td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - 
                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($leave->status == 'pending')
                                    <flux:badge variant="warning">Pending</flux:badge>
                                @elseif($leave->status == 'approved')
                                    <flux:badge variant="success">Disetujui</flux:badge>
                                @else
                                    <flux:badge variant="danger">Ditolak</flux:badge>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pengajuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
