<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Penjualan Produk</h1>
            </div>
        </div>
    </div>
    <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="grid grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input type="date" wire:model.live="start_date" placeholder="Contoh: Dari Tanggal"
                        class="mt-1 form-control" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" wire:model.live="end_date" placeholder="Contoh: Sampai Tanggal"
                        class="mt-1 form-control" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe</label>
                    <select wire:model.live="type" class="mt-1 form-control">
                        <option value="">Semua Tipe</option>
                        <option value="non-resep">Non Resep</option>
                        <option value="resep">Resep</option>
                        <option value="konsultasi">Konsultasi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pabrik</label>
                    <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">

                        <select class="mt-1" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('factory_id', e ? e : null);
                            }
                        });"
                            wire:model.live="factory_id" id="factory_id">
                            <option value="">-- Pilih Pabrik --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $factorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Produk</label>
                    <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">

                        <select class="mt-1" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('product_id', e ? e : null);
                            }
                        });"
                            wire:model.live="product_id" id="product_id">
                            <option value="">-- Pilih Produk --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($product['id']); ?>"><?php echo e($product['name']); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products and Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Top Products Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Top 10 Produk Terlaris</h3>
                <div class="flex items-center space-x-2">
                    
                    <i class="fas fa-trophy text-yellow-500"></i>
                </div>
            </div>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium rounded-full
                                    <?php echo e($index < 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($index + 1); ?>

                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?php echo e($product->product_name); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($product->transaction_count); ?> transaksi</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($product->total_quantity); ?> pcs</p>
                            <p class="text-xs text-green-600">Rp<?php echo e(number_format($product->total_sales, 0, ',', '.')); ?>

                            </p>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-chart-bar text-4xl mb-2"></i>
                        <p>Belum ada data produk</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-lg shadow-lg p-6"
            <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'chart-'.e($start_date).'-'.e($end_date).'-'.e($type).'-'.e($factory_id).'-'.e($product_id).''; ?>wire:key="chart-<?php echo e($start_date); ?>-<?php echo e($end_date); ?>-<?php echo e($type); ?>-<?php echo e($factory_id); ?>-<?php echo e($product_id); ?>">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Chart Penjualan Top 5 Produk</h3>
                <i class="fas fa-chart-pie text-blue-500"></i>
            </div>
            <div class="relative">
                <canvas
                    id="topProductsChart-<?php echo e($start_date); ?>-<?php echo e($end_date); ?>-<?php echo e($type); ?>-<?php echo e($factory_id); ?>-<?php echo e($product_id); ?>"
                    style="max-width: 100%; height: 400px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Produk Terjual</p>
                    <p class="text-2xl font-bold"><?php echo e($topProducts->sum('total_quantity')); ?></p>
                </div>
                <div class="bg-blue-400 rounded-full p-3">
                    <i class="fas fa-boxes text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Penjualan</p>
                    <p class="text-2xl font-bold">Rp<?php echo e(number_format($topProducts->sum('total_sales'), 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="bg-green-400 rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total Transaksi</p>
                    <p class="text-2xl font-bold"><?php echo e($topProducts->sum('transaction_count')); ?></p>
                </div>
                <div class="bg-purple-400 rounded-full p-3">
                    <i class="fas fa-receipt text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Rata-rata per Transaksi</p>
                    <p class="text-2xl font-bold">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topProducts->sum('transaction_count') > 0): ?>
                            Rp<?php echo e(number_format($topProducts->sum('total_sales') / $topProducts->sum('transaction_count'), 0, ',', '.')); ?>

                        <?php else: ?>
                            Rp0
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                </div>
                <div class="bg-orange-400 rounded-full p-3">
                    <i class="fas fa-calculator text-white"></i>
                </div>
            </div>
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                wire:model.live='search'>
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
                        <th>Produk</th>
                        <th>Kode Transaksi</th>
                        <th>Tipe Transaksi</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $transactionProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transactionProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="center">
                                <?php echo e($loop->iteration + ($transactionProducts->currentPage() - 1) * $transactionProducts->perPage()); ?>

                            </td>
                            <td>
                                <p class="font-medium"><?php echo e($transactionProduct->product->name); ?></p>
                                <p class="text-xs text-gray-500">
                                    @Rp<?php echo e(number_format($transactionProduct->price, 0, ',', '.')); ?></p>
                            </td>
                            <td><?php echo e($transactionProduct->transaction->code); ?></td>
                            <td><?php echo e(Str::title(Str::replace('-', ' ', $transactionProduct->transaction->type))); ?></td>
                            <td><?php echo e($transactionProduct->quantity); ?></td>
                            <td>Rp<?php echo e(number_format($transactionProduct->total, 0, ',', '.')); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="no-data">Tidak ada data</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($transactionProducts->firstItem()); ?></span> sampai <span
                        class="font-medium"><?php echo e($transactionProducts->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($transactionProducts->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($transactionProducts->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartInstance = null;
    let currentCanvasId = null;

    function createChart() {
        // Generate canvas ID based on current filters
        const canvasId =
            'topProductsChart-<?php echo e($start_date); ?>-<?php echo e($end_date); ?>-<?php echo e($type); ?>-<?php echo e($factory_id); ?>-<?php echo e($product_id); ?>';
        const canvas = document.getElementById(canvasId);

        if (!canvas) {
            console.log('Canvas not found with ID:', canvasId);
            // Try to find any canvas with topProductsChart in the ID
            const allCanvases = document.querySelectorAll('canvas[id*="topProductsChart"]');
            if (allCanvases.length > 0) {
                const lastCanvas = allCanvases[allCanvases.length - 1];
                console.log('Using canvas:', lastCanvas.id);
                createChartOnCanvas(lastCanvas);
            }
            return;
        }

        createChartOnCanvas(canvas);
    }

    function createChartOnCanvas(canvas) {
        // If canvas ID changed, destroy existing chart
        if (chartInstance && currentCanvasId !== canvas.id) {
            chartInstance.destroy();
            chartInstance = null;
        }

        currentCanvasId = canvas.id;

        // Destroy existing chart if it exists
        if (chartInstance) {
            chartInstance.destroy();
            chartInstance = null;
        }

        // Get chart data from Livewire component
        const chartData = window.Livewire.find('<?php echo e($_instance->getId()); ?>').chartData;
        const ctx = canvas.getContext('2d');

        if (chartData && chartData.labels && chartData.labels.length > 0) {
            chartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: chartData.salesData,
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'
                        ],
                        borderColor: [
                            '#1D4ED8', '#059669', '#D97706', '#DC2626', '#7C3AED'
                        ],
                        borderWidth: 2,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const label = context.label || '';
                                    const value = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(context.parsed);
                                    const quantity = chartData.quantityData[context.dataIndex];
                                    return `${label}: ${value} (${quantity} pcs)`;
                                }
                            }
                        }
                    },
                    cutout: '60%',
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        } else {
            // Show no data message
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = '16px Arial';
            ctx.fillStyle = '#6B7280';
            ctx.textAlign = 'center';
            ctx.fillText('Tidak ada data untuk ditampilkan', canvas.width / 2, canvas.height / 2);
        }
    }

    // Initial load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(createChart, 200);
    });

    // Update on Livewire updates
    document.addEventListener('livewire:updated', function() {
        setTimeout(createChart, 200);
    });

    // Also listen for load event
    document.addEventListener('livewire:load', function() {
        setTimeout(createChart, 200);
    });
</script><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/report/sale-product/admin-report-sale-product-index.blade.php ENDPATH**/ ?>