<div>
    <?php echo $__env->make('livewire.admin.sale.pos.admin-sale-pos-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-full mx-auto p-4 pt-16 grid grid-cols-1 lg:grid-cols-4 gap-6" style="margin-top: 50px;">
        <div class="bg-white rounded-xl shadow-md p-4 h-[calc(100vh-7rem)] flex flex-col md:col-span-4">
            <!-- Header with Title and User Info -->
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-4">
                    <h2 class="font-semibold text-lg">
                        <i class="fas fa-history mr-2"></i>Transaksi
                    </h2>
                </div>
                <div class="text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cashBank): ?>
                            <button wire:click='confirmCloseCashier()'
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2">
                                <i class="fas fa-cash-register"></i>
                                <span>Tutup Kasir</span>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        
                        <button wire:click='openModal()'
                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Data</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex gap-4 mb-4">
                <div class="relative flex-1">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari transaksi..."
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>

                <select wire:model.live="status"
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="completed">Selesai</option>
                    <option value="take_medicine">Pengambilan Obat</option>
                    <option value="process">Proses</option>
                    <option value="draft">Draft</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>

                <select wire:model.live="type_transaction"
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Tipe</option>
                    <option value="non-resep">Non-Resep</option>
                    <option value="resep">Resep</option>
                    <option value="konsultasi">Konsultasi</option>
                </select>

                <input wire:model.live="date" type="date"
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

                <button wire:click="resetFilters" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    <i class="fas fa-refresh"></i> Reset
                </button>
            </div>

            <!-- Patient Filter Section -->
            

            <!-- Loading Indicator -->
            <div wire:loading wire:target="search,status,type_transaction,date,patient_company_role_transaction_id"
                class="mb-4">
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Loading...
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="flex-1 overflow-y-auto scrollbar-custom" wire:loading.class="opacity-50">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 bg-white border-b-2">
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 text-left font-medium">No. Transaksi</th>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Pelanggan</th>
                            <th class="py-3 px-4 text-left font-medium">Jenis</th>
                            <th class="py-3 px-4 text-left font-medium">Total</th>
                            <th class="py-3 px-4 text-left font-medium">Status</th>
                            <th class="py-3 px-4 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'transaction-row-'.e($transaction->id).'-'.e($loop->index).''; ?>wire:key="transaction-row-<?php echo e($transaction->id); ?>-<?php echo e($loop->index); ?>"
                                class="border-b hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-4"><?php echo e($transaction->code); ?></td>
                                <td class="py-3 px-4"><?php echo e($transaction->created_at->format('Y-m-d')); ?></td>
                                <td class="py-3 px-4"><?php echo e($transaction->patient_name ?? 'Unknown'); ?></td>
                                <td class="py-3 px-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type == 'non-resep'): ?>
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Non-Resep</span>
                                    <?php elseif($transaction->type == 'resep'): ?>
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Resep</span>
                                    <?php else: ?>
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Konsultasi</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="py-3 px-4">Rp
                                    <?php echo e(number_format($transaction->grand_total_price ?? 0, 0, ',', '.')); ?></td>
                                <td class="py-3 px-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($transaction->status):
                                        case ('completed'): ?>
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Selesai</span>
                                        <?php break; ?>

                                        <?php case ('process'): ?>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Menunggu
                                                Pembayaran</span>
                                        <?php break; ?>

                                        <?php case ('draft'): ?>
                                            <span
                                                class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Draft</span>
                                        <?php break; ?>

                                        <?php case ('take_medicine'): ?>
                                            <span
                                                class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pengambilan
                                                Obat</span>
                                        <?php break; ?>

                                        <?php default: ?>
                                            <span
                                                class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Dibatalkan</span>
                                    <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($transaction->status):
                                        case ('completed'): ?>
                                            <button class="text-blue-600 hover:text-blue-800 mx-1"
                                                wire:click="openDetail('<?php echo e($transaction->id); ?>')" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->transaction_recipes_count > 0): ?>
                                                <a target="_blank" href="<?php echo e(route('user.receipt.recipe', $transaction->id)); ?>"
                                                    class="text-yellow-600 hover:text-yellow-800 mx-1" title="Cetak">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <button onclick="printInvoiceFromPage('<?php echo e($transaction->id); ?>','satuan')"
                                                class="text-green-600 hover:text-green-800 mx-1" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button onclick="printInvoiceFromPage('<?php echo e($transaction->id); ?>','total')"
                                                class="text-red-600 hover:text-red-800 mx-1" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <a target="_blank" href="<?php echo e(route('user.receipt.receipt', $transaction->id)); ?>"
                                                class="text-blue-600 hover:text-blue-800 mx-1" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDelete('<?php echo e($transaction->id); ?>')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php break; ?>

                                        <?php case ('process'): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->hasRole(['Super Admin', 'Kasir'])): ?>
                                                <button class="text-blue-600 hover:text-blue-800 mx-1"
                                                    wire:click="openDetail('<?php echo e($transaction->id); ?>')" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-800 mx-1"
                                                    wire:click="confirmDelete('<?php echo e($transaction->id); ?>')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="text-red-600 hover:text-red-800 mx-1"
                                                    wire:click="confirmDelete('<?php echo e($transaction->id); ?>')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php break; ?>

                                        <?php case ('draft'): ?>
                                            <button class="text-blue-600 hover:text-blue-800 mx-1"
                                                wire:click="openDetail('<?php echo e($transaction->id); ?>')" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDelete('<?php echo e($transaction->id); ?>')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php break; ?>

                                        <?php case ('take_medicine'): ?>
                                            <button class="text-blue-600 hover:text-blue-800 mx-1" title="Lihat Detail"
                                                wire:click="openDetail('<?php echo e($transaction->id); ?>')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->transaction_recipes_count > 0): ?>
                                                <a target="_blank"
                                                    href="<?php echo e(route('user.receipt.recipe', $transaction->id)); ?>"
                                                    class="text-yellow-600 hover:text-yellow-800 mx-1" title="Cetak">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <button onclick="printInvoiceFromPage('<?php echo e($transaction->id); ?>','satuan')"
                                                class="text-green-600 hover:text-green-800 mx-1" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button onclick="printInvoiceFromPage('<?php echo e($transaction->id); ?>','total')"
                                                class="text-red-600 hover:text-red-800 mx-1" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <a target="_blank" href="<?php echo e(route('user.receipt.receipt', $transaction->id)); ?>"
                                                class="text-blue-600 hover:text-blue-800 mx-1" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDelete('<?php echo e($transaction->id); ?>')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php break; ?>

                                        <?php case ('canceled'): ?>
                                            <button class="text-blue-600 hover:text-blue-800 mx-1" title="Lihat Detail"
                                                wire:click="openDetail('<?php echo e($transaction->id); ?>')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDelete('<?php echo e($transaction->id); ?>')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php break; ?>

                                        <?php default: ?>
                                            <button class="text-blue-600 hover:text-blue-800 mx-1" title="Lihat Detail"
                                                wire:click="openDetail('<?php echo e($transaction->id); ?>')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                    <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'empty-transactions-row'; ?>wire:key="empty-transactions-row">
                                    <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                        Tidak ada data transaksi
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $status || $type_transaction || $date || $patient_company_role_transaction_id): ?>
                                            <div class="mt-2">
                                                <button wire:click="resetFilters"
                                                    class="text-blue-600 hover:text-blue-800">
                                                    Reset filter untuk melihat semua data
                                                </button>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between border-t pt-4 mt-4">
                    <div class="text-sm text-gray-500">
                        Menampilkan <?php echo e($transactions->firstItem()); ?> sampai <?php echo e($transactions->lastItem()); ?>

                        dari <?php echo e($transactions->total()); ?> data
                    </div>

                    <div class="flex items-center space-x-2">
                        <?php echo e($transactions->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    <?php $__env->startPush('scripts'); ?>
        <script>
            // 58mm printer biasanya 32 karakter
            const PAPER_WIDTH = <?php echo e($paperWidth ?? 48); ?>; // atur sesuai printer kamu

            // 🔑 flag dari backend (true / false)
            const CASH_DRAWER_ENABLED = <?php echo json_encode($cashDrawer, 15, 512) ?>;

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
    <?php $__env->stopPush(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/sale/pos/admin-sale-pos-index.blade.php ENDPATH**/ ?>