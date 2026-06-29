<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Transaksi Pending Payment</h1>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
        <div class="flex p-1 bg-gray-100 rounded-lg w-fit">
            <button wire:click="setStatus('draft')"
                class="px-4 py-2 text-sm font-medium rounded-md transition-all <?php echo e($status_payment === 'draft' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                Draft
            </button>
            <button wire:click="setStatus('paid')"
                class="px-4 py-2 text-sm font-medium rounded-md transition-all <?php echo e($status_payment === 'paid' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                Paid
            </button>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-2">Tampil</span>
            <select class="mt-1 form-control" wire:model.live='perPage'>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-700 ml-2">data</span>
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..." wire:model.live='search'>
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search h-3 w-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Tenor</th>
                        <th>Sisa Tenor</th>
                        <th class="text-right">Total Tagihan</th>
                        <th class="text-right">Terbayar</th>
                        <th class="text-right">Sisa Tagihan</th>
                        <th class="center">Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="center"><?php echo e($transactions->firstItem() + $index); ?></td>
                            <td><?php echo e($transaction->code); ?></td>
                            <td><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <div class="font-medium text-gray-900"><?php echo e($transaction->patient_name ?? '-'); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($transaction->patient?->member_id ?? ''); ?></div>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->installment_count): ?>
                                    <div>
                                        <span class="font-medium text-blue-600"><?php echo e($transaction->installment_count); ?>x</span>
                                        <span
                                            class="text-[10px] text-gray-400 capitalize">(<?php echo e($transaction->installment_period ?? '-'); ?>)</span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-300">-</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->installment_count): ?>
                                    <?php
                                        $paidCount = $transaction->transactionPayments->where('is_down_payment', false)->count();
                                        $remainingTenor = max(0, $transaction->installment_count - $paidCount);
                                    ?>
                                    <span class="font-medium <?php echo e($remainingTenor > 0 ? 'text-orange-600' : 'text-green-600'); ?>">
                                        <?php echo e($remainingTenor); ?>x
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-300">-</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-right font-medium">Rp <?php echo number_format($transaction->grand_total_price, 0, ',', '.'); ?></td>
                            <td class="text-right font-medium text-green-600">Rp <?php echo number_format($transaction->payment_amount, 0, ',', '.'); ?></td>
                            <td class="text-right font-medium text-red-600">Rp <?php echo number_format($transaction->remaining_bill, 0, ',', '.'); ?></td>
                            <td class="center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status_payment == 'paid'): ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php elseif($transaction->status_payment == 'draft'): ?>
                                    <span class="badge badge-gray">Draft</span>
                                <?php else: ?>
                                    <span class="badge badge-warning"><?php echo e(ucfirst($transaction->status_payment)); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="center">
                                <div class="flex items-center gap-1 justify-center">
                                    <a href="<?php echo e(route('user.sale.pending.detail', ['transaction_id' => $transaction->id])); ?>"
                                        class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors"
                                        title="Detail & Bayar">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status_payment != 'paid'): ?>
                                        <?php
                                            $waPhone = '';
                                            if ($transaction->patient && $transaction->patient->phone) {
                                                $waPhone = $transaction->patient->phone;
                                                if (substr($waPhone, 0, 1) === '0') {
                                                    $waPhone = '62' . substr($waPhone, 1);
                                                }
                                            }
                                            $waMessage = 'Halo, ' . ($transaction->patient_name ?? 'Pasien') . '. Kami dari klinik ingin mengingatkan bahwa ada tagihan transaksi (' . $transaction->code . ') yang belum lunas (Sisa: Rp ' . number_format($transaction->remaining_bill, 0, ',', '.') . '). Mohon segera diselesaikan.';
                                            $waUrl = 'https://wa.me/' . $waPhone . '?text=' . urlencode($waMessage);
                                        ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($waPhone): ?>
                                            <a target="_blank" href="<?php echo e($waUrl); ?>"
                                                class="btn btn-icon text-teal-600 hover:text-teal-800 transition-colors"
                                                title="Kirim Pesan WhatsApp">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <button onclick="printInvoiceFromPage('<?php echo e($transaction->id); ?>','total')"
                                        class="btn btn-icon text-red-600 hover:text-red-800 transition-colors"
                                        title="Cetak Invoice Total">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="11" class="no-data">Tidak ada data transaksi</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($transactions->firstItem()); ?></span> sampai <span
                        class="font-medium"><?php echo e($transactions->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($transactions->total()); ?></span> hasil
                </div>
                <div>
                    <?php echo e($transactions->links('vendor.livewire.custom')); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div wire:ignore.self id="modalPayment"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div
            class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800">Modal Metode Bayar</h2>
                </div>
                <button wire:click="closeModalPayment()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>
            <div class="px-6 py-4 text-gray-600">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Pilih Metode Bayar <span
                            class="text-red-600">*</span></label>
                    <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                        <select
                            class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            x-data x-ref="input" x-init="$($refs.input).selectize({
                                dropdownParent: 'body',
                                allowClear: true,
                                plugins: ['clear_button'],
                                onChange: function(e) {
                                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('payment_method_id', e ? e : null);
                                }
                            });" wire:model.live="payment_method_id" id="payment_method_id">
                            <option value="">-- Pilih Metode Bayar --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($paymentMethod->id); ?>"><?php echo e($paymentMethod->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_method_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Total Pembayaran <span class="text-red-600">*</span>
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            Rp
                        </span>
                        <input type="text" onkeyup="convertToRupiah(this)" wire:model.live="payment_amount"
                            placeholder="XXXXXXXXXXXX"
                            class="block w-full rounded-r-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <!-- Notes -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea wire:model.lazy='description' rows="3" placeholder="Tambahkan catatan jika diperlukan"
                        class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
            </div>
            <div class="flex justify-between items-center px-6 py-4 border-t bg-white">
                <div class="text-sm text-gray-500"></div>
                <div class="flex gap-2">
                    <button wire:click="closeModalPayment()" wire:loading.attr="disabled" wire:target="submitPayment"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button wire:click='submitPayment()' wire:loading.attr="disabled" wire:target="submitPayment"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                        <span wire:loading.remove wire:target="submitPayment">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </span>
                        <span wire:loading wire:target="submitPayment">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        // 58mm printer biasanya 32 karakter
        const PAPER_WIDTH = <?php echo e($paperWidth ?? 48); ?>; // atur sesuai printer kamu

        // 🔑 flag dari backend (true / false)
        const CASH_DRAWER_ENABLED = <?php echo json_encode($cashDrawer ?? false, 15, 512) ?>;

        // 🔹 Format kiri-kanan
        function formatLine(left, right, width = PAPER_WIDTH) {
            left = left.toString();
            right = right.toString();
            let space = width - left.length - right.length;
            if (space < 1) space = 1;
            return left + " ".repeat(space) + right;
        }

        // 🔹 Rata tengah
        function centerText(text, width = PAPER_WIDTH) {
            let lines = wrapText(text, width);
            return lines.map(line => {
                let space = Math.floor((width - line.length) / 2);
                if (space < 0) space = 0;
                return " ".repeat(space) + line;
            }).join("\n");
        }

        // 🔹 Rata kiri
        function leftText(text, width = PAPER_WIDTH) {
            return wrapText(text, width).join("\n");
        }

        // 🔹 Wrap text sesuai width
        function wrapText(text, width = PAPER_WIDTH) {
            let result = [];
            let remaining = text.trim();
            while (remaining.length > width) {
                result.push(remaining.substring(0, width));
                remaining = remaining.substring(width);
            }
            if (remaining.length > 0) result.push(remaining);
            return result;
        }

        async function printInvoiceFromPage(transactionId, type = 'satuan') {
            try {
                // 1. Ambil halaman invoice
                let url = '';

                if (type === 'total') {
                    url = `/print/invoice-total/${transactionId}`;
                } else if (type === 'satuan') {
                    url = `/print/invoice/${transactionId}`;
                } else {
                    url = `/print/invoice/${transactionId}`; // fallback default
                }

                let res = await fetch(url);

                let html = await res.text();
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");

                // --- Logo Section ---
                let storeName = doc.querySelector(".store-name")?.innerText.trim() ?? "<?php echo e(config('app.name')); ?>";
                let storeInfoLines = doc.querySelectorAll(".store-info-line");

                let logoText = centerText(storeName) + "\n";
                storeInfoLines.forEach(line => {
                    logoText += centerText(line.innerText.trim()) + "\n";
                });
                logoText += "=".repeat(PAPER_WIDTH) + "\n";

                // --- Info Section ---
                let infoRows = doc.querySelectorAll(".info-section .info-row");
                let infoText = "";
                infoRows.forEach(row => {
                    let label = row.querySelector(".label, .info-label")?.innerText.trim() ?? "";
                    let value = row.querySelector(".value, .info-value")?.innerText.trim() ?? "";
                    if (label && value) {
                        infoText += formatLine(label, value) + "\n";
                    }
                });
                infoText += "-".repeat(PAPER_WIDTH) + "\n";

                // --- Detail Transaksi ---
                let itemsText = "";
                let items = doc.querySelectorAll(".transaction-item");
                items.forEach(div => {
                    let name = div.querySelector(".item-name")?.innerText.trim() || "";
                    let total = div.querySelector(".item-total")?.innerText.trim() || "";

                    if (name) {
                        let maxNameLength = PAPER_WIDTH - total.length - 2;
                        if (name.length > maxNameLength) {
                            // Baris pertama
                            let firstLine = name.substring(0, maxNameLength);
                            itemsText += formatLine(firstLine, total) + "\n";

                            // Baris sisa
                            let remaining = name.substring(maxNameLength);
                            wrapText(remaining, PAPER_WIDTH).forEach(line => {
                                itemsText += leftText(line) + "\n";
                            });
                        } else {
                            itemsText += formatLine(name, total) + "\n";
                        }
                    }
                });

                // --- Summary ---
                let summaryRows = doc.querySelectorAll(".summary-section .summary-row");
                let summaryText = "\n" + "-".repeat(PAPER_WIDTH) + "\n";
                summaryRows.forEach(row => {
                    let label = row.querySelector(".label")?.innerText.trim() ?? "";
                    let value = row.querySelector(".value")?.innerText.trim() ?? "";

                    if (label && value) {
                        if (label.toUpperCase() === "TOTAL" || label.toUpperCase() === "GRAND TOTAL") {
                            let boldOn = "\x1B\x45\x01"; // ESC E 1 → Bold ON
                            let boldOff = "\x1B\x45\x00"; // ESC E 0 → Bold OFF
                            summaryText += boldOn + formatLine(label, value) + boldOff + "\n";
                        } else {
                            summaryText += formatLine(label, value) + "\n";
                        }
                    }
                });

                // --- Footer ---
                let footerLines = doc.querySelectorAll(".footer-line");
                let footerText = "\n" + "-".repeat(PAPER_WIDTH) + "\n";
                footerLines.forEach(line => {
                    footerText += centerText(line.innerText.trim()) + "\n";
                });
                footerText += "\n";

                let printEnd = "\n\n\n\n\n";

                // ✅ Satukan semua
                let invoiceText = logoText + infoText + itemsText + summaryText + footerText + printEnd;

                // 2. Deteksi platform
                let ua = navigator.userAgent.toLowerCase();
                if (/android/.test(ua)) {
                    printWithRawBT(invoiceText);
                    return;
                } else if (/iphone|ipad|ipod/.test(ua)) {
                    alert("⚠️ Print langsung via Bluetooth tidak didukung di iOS. Gunakan AirPrint / Aplikasi Native.");
                    return;
                } else {
                    await printWithWebBluetooth(invoiceText);
                }

            } catch (err) {
                console.error("⚠️ Gagal print:", err);
                let msg = err?.message ?? (typeof err === "string" ? err : JSON.stringify(err));
                alert("⚠️ Gagal print: " + msg);
            }
        }

        // 🟢 Android RawBT Flow
        function printWithRawBT(text) {
            let encoded = encodeURIComponent(text);
            window.location.href = "rawbt:" + encoded;
        }

        // 🟢 Desktop Web Bluetooth Flow
        async function printWithWebBluetooth(invoiceText) {
            try {
                const device = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: [
                        'device_information',
                        0x180F,
                        0xFFE0, 0xFFE1,
                        0xFFF0, 0xFFF1
                    ]
                });

                const server = await device.gatt.connect();
                const services = await server.getPrimaryServices();

                let writableChar = null;
                for (const service of services) {
                    const characteristics = await service.getCharacteristics();
                    for (const char of characteristics) {
                        if (char.properties.write || char.properties.writeWithoutResponse) {
                            writableChar = char;
                            break;
                        }
                    }
                    if (writableChar) break;
                }

                if (!writableChar) throw new Error("Tidak menemukan characteristic 'write' di printer!");

                let encoder = new TextEncoder();
                let escposInit = new Uint8Array([0x1B, 0x40]); // reset
                let escposFontB = new Uint8Array([0x1B, 0x4D, 0x01]); // font B
                let escposLineSpacing = new Uint8Array([0x1B, 0x33, 0x12]);
                let escposCut = new Uint8Array([0x1D, 0x56, 0x00]); // cut
                let openDrawer = new Uint8Array([0x1B, 0x70, 0x01, 0x25, 0x32]); // ✅ open cash drawer

                // Hitung total panjang buffer sesuai flag drawer
                let fullData = new Uint8Array(
                    escposInit.length +
                    escposFontB.length +
                    escposLineSpacing.length +
                    encoder.encode(invoiceText).length +
                    escposCut.length +
                    (CASH_DRAWER_ENABLED ? openDrawer.length : 0)
                );

                let offset = 0;
                fullData.set(escposInit, offset);
                offset += escposInit.length;
                fullData.set(escposFontB, offset);
                offset += escposFontB.length;
                fullData.set(escposLineSpacing, offset);
                offset += escposLineSpacing.length;
                let body = encoder.encode(invoiceText);
                fullData.set(body, offset);
                offset += body.length;
                fullData.set(escposCut, offset);
                offset += escposCut.length;

                // ✅ hanya tambahkan openDrawer jika flag true
                if (CASH_DRAWER_ENABLED) {
                    fullData.set(openDrawer, offset);
                    offset += openDrawer.length;
                }

                const chunkSize = 512;
                for (let i = 0; i < fullData.length; i += chunkSize) {
                    let chunk = fullData.slice(i, i + chunkSize);
                    await writableChar.writeValue(chunk);
                    await new Promise(r => setTimeout(r, 50));
                }

                alert("✅ Invoice berhasil dicetak" + (CASH_DRAWER_ENABLED ? " & cash drawer terbuka!" : "!"));

            } catch (err) {
                console.error("⚠️ Gagal print:", err);
                throw err;
            }
        }
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/sale/pending/admin-sale-pending-index.blade.php ENDPATH**/ ?>