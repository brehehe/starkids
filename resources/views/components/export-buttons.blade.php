@props([
    'excelAction' => 'exportExcel',
    'pdfAction' => 'exportPDF',
    'excelText' => 'Excel',
    'pdfText' => 'PDF',
    'size' => 'sm',
])

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    <button
        type="button"
        wire:click="{{ $excelAction }}"
        wire:loading.attr="disabled"
        wire:target="{{ $excelAction }}"
        class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-lg shadow-sm transition-all duration-150 disabled:opacity-50 cursor-pointer"
        title="Export Data ke Excel (.xlsx)">
        <span wire:loading.remove wire:target="{{ $excelAction }}" class="inline-flex items-center gap-1.5">
            <i class="fa-solid fa-file-excel text-sm"></i>
            <span>{{ $excelText }}</span>
        </span>
        <span wire:loading wire:target="{{ $excelAction }}" class="inline-flex items-center gap-1.5">
            <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
            <span>Exporting...</span>
        </span>
    </button>

    <button
        type="button"
        wire:click="{{ $pdfAction }}"
        wire:loading.attr="disabled"
        wire:target="{{ $pdfAction }}"
        class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 active:bg-rose-800 rounded-lg shadow-sm transition-all duration-150 disabled:opacity-50 cursor-pointer"
        title="Export Data ke Dokumen PDF (.pdf)">
        <span wire:loading.remove wire:target="{{ $pdfAction }}" class="inline-flex items-center gap-1.5">
            <i class="fa-solid fa-file-pdf text-sm"></i>
            <span>{{ $pdfText }}</span>
        </span>
        <span wire:loading wire:target="{{ $pdfAction }}" class="inline-flex items-center gap-1.5">
            <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
            <span>Exporting...</span>
        </span>
    </button>
</div>

