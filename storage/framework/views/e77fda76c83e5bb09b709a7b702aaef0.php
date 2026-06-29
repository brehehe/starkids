<?php $__env->startPush('styles'); ?>
<style>
    /* Tab Scrollbar */
    .tab-scroll-wrapper::-webkit-scrollbar { height: 6px; }
    .tab-scroll-wrapper::-webkit-scrollbar-track { @apply bg-gray-50; }
    .tab-scroll-wrapper::-webkit-scrollbar-thumb { @apply bg-gray-300 rounded; }

    /* Custom Scrollbar for tables */
    .overflow-x-auto::-webkit-scrollbar,
    .scroll-section::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    .overflow-x-auto::-webkit-scrollbar-track,
    .scroll-section::-webkit-scrollbar-track {
        @apply bg-gray-100 rounded;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb,
    .scroll-section::-webkit-scrollbar-thumb {
        @apply bg-gray-400 rounded;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover,
    .scroll-section::-webkit-scrollbar-thumb:hover {
        @apply bg-gray-500;
    }

    /* Tab active indicator */
    .tab-link.active::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #3b82f6, #2563eb); border-radius: 3px 3px 0 0;
    }

    /* Table header gradient */
    .table-header-gradient { background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); }

    /* Section title */
    .section-title { @apply px-6 py-4 text-lg font-semibold text-white flex items-center; }
</style>
<?php $__env->stopPush(); ?>

<div id="report-container" class="w-full px-4 py-4">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">LAPORAN BULANAN KEGIATAN KLINIK</h2>
            <p class="text-sm text-gray-500">Laporan Komprehensif Aktivitas Klinik Per Bulan</p>
        </div>
        <div class="flex gap-3 items-center">
            <div class="flex gap-2">
                <button onclick="exportExcelFull()" class="inline-flex items-center px-4 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="bi bi-file-earmark-excel text-lg me-2"></i> Export Excel
                </button>
                <!-- <button onclick="exportPdfFull()" class="inline-flex items-center px-4 py-2.5 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="bi bi-file-earmark-pdf text-lg me-2"></i> Export PDF
                </button> -->
            </div>

            <div class="h-8 w-px bg-gray-300 mx-1"></div>

            <div class="flex items-center gap-2">
                <label class="font-semibold text-gray-700">Tahun:</label>
                <select wire:model.live="year" class="border border-gray-300 rounded-lg px-3 py-2 w-32 focus:ring-blue-500 focus:border-blue-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = date('Y'); $i >= date('Y') - 5; $i--): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
        </div>
    </div>

    
    <ul class="flex flex-wrap text-sm font-medium text-center">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <li class="me-2 mb-2">
                <button wire:click="selectMonth('<?php echo e($key); ?>')"
                    class="inline-block px-4 py-2.5 rounded-lg transition-all <?php echo e($selectedMonth === $key ? 'text-white bg-blue-600 font-semibold' : 'text-gray-700 bg-gray-100 hover:text-blue-600 hover:bg-gray-200'); ?>">
                    <i class="bi bi-calendar3"></i><?php echo e($label); ?>

                </button>
            </li>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </ul>

    
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="section-title bg-gradient-to-r from-white-600 to-white-700 p-4">
            <i class="bi bi-clipboard-data mr-2"></i>A. Data Umum (wajib diisi)
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold" style="width: 60px;">No</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold" style="width: 40%;">Uraian</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold">Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $dataUmum = [
                            'Nama Klinik' => $companies['name'] ?? '-',
                            'Kode Faskes' => $companies['code_health_facility'] ?? '-',
                            'Alamat Lengkap Klinik' => $companies['company_detail']['address'] ?? '-',
                            'Nama Pimpinan Klinik' => $companies['pic_name'] ?? '-',
                            'Telepon/ Ponsel Klinik' => $companies['phone'] ?? '-',
                            'e-mail Klinik' => $companies['email'] ?? '-',
                            'Bulan & Tahun Pelaporan' => $months[$selectedMonth] . ' ' . $year
                        ];
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dataUmum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uraian => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-center border border-gray-300 font-semibold"><?php echo e($loop->iteration); ?></td>
                            <td class="px-4 py-3 border border-gray-300"><?php echo e($uraian); ?></td>
                            <td class="px-4 py-3 border border-gray-300 <?php echo e($loop->last ? 'font-semibold text-blue-600' : ''); ?>"><?php echo e($data); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="section-title bg-gradient-to-r from-white-600 to-white-700 p-4">
            <i class="bi bi-clipboard-data mr-2"></i>B. Data Kelahiran di Klinik (apabila Klinik menyelenggarakan pelayanan persalinan)
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap">Nama Bayi</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L/P</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap">Nama Orang Tua</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap">Alamat Lengkap</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">Tanggal & Jam Lahir</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">Umur Kehamilan Saat Lahir</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">BB/TB</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">Normal/Dirujuk</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap">Uraian</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">Data</th>
                    </tr>
                </thead>
                <tbody>
                   <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah Bayi Baru Lahir Mendapat IMD</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="section-title bg-gradient-to-r from-white-600 to-white-700 p-4">
            <i class="bi bi-clipboard-data mr-2"></i>C. Data Kematian di Klinik
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2" style="width: 50px;">No</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap" rowspan="2">Nama</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap" rowspan="2">NIK</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2">Umur</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap" rowspan="2">Alamat Lengkap</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2">L/P</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2">Tanggal Meninggal</th>
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap" rowspan="2">Tempat Meninggal</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" colspan="2">Sebab Dasar Kematian</th>
                    </tr>
                    <tr class="table-header-gradient">
                        <th class="px-4 py-3 border border-gray-300 font-bold whitespace-nowrap">Diagnosa</th>
                        <th class="px-4 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">ICD 10</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="section-title bg-gradient-to-r from-white-600 to-white-700 p-4">
            <i class="bi bi-clipboard-data mr-2"></i>D. Data Kesakitan di Klinik
        </div>

        
        <div class="p-4 bg-gray-100">
            <h4 class="font-semibold text-gray-800 mb-3">1. Data Kesakitan</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="table-header-gradient">
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2" style="width: 50px;">No</th>
                            <th class="px-2 py-2 border border-gray-300 font-bold whitespace-nowrap" rowspan="2">Jenis Penyakit</th>
                            <th class="px-2 py-2 border border-gray-300 font-bold whitespace-nowrap" rowspan="2">ICD 10</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap" colspan="10">Jumlah Kasus Per Kelompok Umur</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2">L</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2">P</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2">JML</th>
                        </tr>
                        <tr class="table-header-gradient">
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">0-7 hari</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">8-28 hari</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">1-11 bln</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">1-4 th</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">5-9 th</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">10-14 th</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">15-19 th</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">20-44 th</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">45-59 th</th>
                            <th class="px-2 py-2 text-center border border-gray-300 font-bold whitespace-nowrap">>59 th</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activities['pain_data']['pain_data']) && $activities['pain_data']['pain_data']->count() > 0): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activities['pain_data']['pain_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-center border border-gray-300"><?php echo e($index + 1); ?></td>
                                    <td class="px-3 py-2 border border-gray-300"><?php echo e($pain['icd10_name']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['icd10_code']); ?></td>

                                    
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['0-7_days']['male'] + $pain['age_groups']['0-7_days']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['8-28_days']['male'] + $pain['age_groups']['8-28_days']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['1-11_months']['male'] + $pain['age_groups']['1-11_months']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['1-4_years']['male'] + $pain['age_groups']['1-4_years']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['5-9_years']['male'] + $pain['age_groups']['5-9_years']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['10-14_years']['male'] + $pain['age_groups']['10-14_years']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['15-19_years']['male'] + $pain['age_groups']['15-19_years']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['20-44_years']['male'] + $pain['age_groups']['20-44_years']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['45-59_years']['male'] + $pain['age_groups']['45-59_years']['female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($pain['age_groups']['above_59_years']['male'] + $pain['age_groups']['above_59_years']['female']); ?></td>

                                    
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-blue-50 font-semibold"><?php echo e($pain['total_male']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-pink-50 font-semibold"><?php echo e($pain['total_female']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-200 font-bold"><?php echo e($pain['grand_total']); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="16" class="px-3 py-4 text-center border border-gray-300 text-gray-500">
                                    Tidak ada data untuk bulan <?php echo e($months[$selectedMonth]); ?> <?php echo e($year); ?>

                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="p-4 bg-gray-50">
            <h4 class="font-semibold text-gray-800 mb-3">2. Data Kesakitan Terbanyak</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="table-header-gradient">
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                            <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Jenis Penyakit</th>
                            <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">ICD 10</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activities['pain_data']['top_pain_data']) && $activities['pain_data']['top_pain_data']->count() > 0): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activities['pain_data']['top_pain_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $disease): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-center border border-gray-300"><?php echo e($index + 1); ?></td>
                                    <td class="px-3 py-2 border border-gray-300"><?php echo e($disease['icd10_name']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"><?php echo e($disease['icd10_code']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-blue-50 font-semibold"><?php echo e($disease['total_male']); ?></td>
                                    <td class="px-3 py-2 text-center border border-gray-300 bg-pink-50 font-semibold"><?php echo e($disease['total_female']); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-center border border-gray-300 text-gray-500">
                                    Tidak ada data untuk bulan <?php echo e($months[$selectedMonth]); ?> <?php echo e($year); ?>

                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="section-title bg-gradient-to-r from-white-600 to-white-700 p-4">
            <i class="bi bi-clipboard-data mr-2"></i>E. Data Pelayanan Kesehatan Klinik
        </div>

        
        <div class="p-4 bg-gray-100">
            <h4 class="font-semibold text-gray-800 mb-3">1. Data Kunjungan Klinik (wajib diisi)</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="table-header-gradient">
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" rowspan="2" style="width: 50px;">No</th>
                            <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap" rowspan="2">Kegiatan</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" colspan="2">Kunjungan Baru</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" colspan="2">Kunjungan Lama</th>
                        </tr>
                        <tr class="table-header-gradient">
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activities['clinic_visit_data']) && count($activities['clinic_visit_data']) > 0): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activities['clinic_visit_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-center border border-gray-300"><?php echo e($index + 1); ?></td>
                                <td class="px-3 py-2 border border-gray-300"><?php echo e($row['name']); ?></td>
                                <td class="px-3 py-2 text-center border border-gray-300 bg-blue-50"><?php echo e($row['new_l']); ?></td>
                                <td class="px-3 py-2 text-center border border-gray-300 bg-pink-50"><?php echo e($row['new_p']); ?></td>
                                <td class="px-3 py-2 text-center border border-gray-300 bg-blue-50"><?php echo e($row['old_l']); ?></td>
                                <td class="px-3 py-2 text-center border border-gray-300 bg-pink-50"><?php echo e($row['old_p']); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        
                        <tr class="bg-gray-100 font-bold">
                            <td class="px-3 py-2 text-center border border-gray-300" colspan="2">Total</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-blue-100"><?php echo e(collect($activities['clinic_visit_data'])->take(2)->sum('new_l')); ?></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-pink-100"><?php echo e(collect($activities['clinic_visit_data'])->take(2)->sum('new_p')); ?></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-blue-100"><?php echo e(collect($activities['clinic_visit_data'])->take(2)->sum('old_l')); ?></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-pink-100"><?php echo e(collect($activities['clinic_visit_data'])->take(2)->sum('old_p')); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center border border-gray-300 text-gray-500">
                                Tidak ada data kunjungan untuk periode ini
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="p-4 bg-gray-50">
            <h4 class="font-semibold text-gray-800 mb-3">Data Rujukan (wajib diisi)</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="table-header-gradient">
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                            <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">1</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien yang dirujuk ke Puskesmas, klinik rawat inap (terkait Program Nasional)</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">2</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien penyakit menular yang dirujuk ke Rumah Sakit</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">3</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien penyakit tidak menular dirujuk ke Rumah Sakit</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">4</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien yang dirujuk balik dari Puskesmas dan klinik rawat inap.</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">5</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien yang dirujuk balik dari Rumah Sakit</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="bg-gray-200 font-bold">
                            <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                            <td class="px-3 py-2 text-center border border-gray-400">0</td>
                            <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="p-4 bg-gray-100">
            <h4 class="font-semibold text-gray-800 mb-3">2. Data Pasien Rawat Inap (apabila Klinik menyelenggarakan pelayanan rawat inap)</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="table-header-gradient">
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                            <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">1</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien rawat inap</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">2</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah ibu hamil, melahirkan, nifas dengan gangguan kesehatan dirawat inap</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">3</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah anak berumur < 5 tahun sakit dirawat inap</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">4</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien yang menderita cedera/ kecelakaan dirawat inap</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">5</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien penyakit tidak menular dirawat inap</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">6</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pasien yang keluar sembuh dari rawat inap Klinik</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="bg-gray-200 font-bold">
                            <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                            <td class="px-3 py-2 text-center border border-gray-400">0</td>
                            <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="p-4 bg-gray-50">
            <h4 class="font-semibold text-gray-800 mb-3">3. Data Pelayanan Keluarga Berencana (apabila Klinik menyelenggarakan pelayanan KB)</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="table-header-gradient">
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                            <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                            <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">1</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan IUD</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">2</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan PIL KB</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">3</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan kondom</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">4</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan obat vaginal</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">5</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan Metode Operasi Pria (MOP)</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">6</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan Metode Operasi Wanita (MOW)</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">7</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan suntik KB</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">8</td>
                            <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan implant KB</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border border-gray-300">9</td>
                            <td class="px-3 py-2 border border-gray-300">Lain-lain (…………….sebutkan)</td>
                            <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        </tr>
                        <tr class="bg-gray-200 font-bold">
                            <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                            <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-4 bg-gray-100">
        <h4 class="font-semibold text-gray-800 mb-3">4. Data Pelayanan Kesehatan Gigi dan Mulut (apabila Klinik menyelenggarakan pelayanan kesehatan gigi dan mulut)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah penambalan gigi tetap</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">2</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah penambalan gigi sulung</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">3</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pencabutan gigi tetap</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">4</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pencabutan gigi sulung</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">5</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pembersihan karang gigi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">6</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah premedikasi/ pengobatan</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">7</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan rujukan gigi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">8</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemasangan gigi tiruan</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">9</td>
                        <td class="px-3 py-2 border border-gray-300">Lain-lain (…………….sebutkan)</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4 bg-gray-50">
        <h4 class="font-semibold text-gray-800 mb-3">5. Data Pelayanan Laboratorium (apabila Klinik menyelenggarakan pelayanan laboratorium)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan hematologi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">2</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan kimia klinik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">3</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan urinalisa</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">4</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan mikrobiologi dan parasitologi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">5</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan imunologi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">6</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan tinja</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">7</td>
                        <td class="px-3 py-2 border border-gray-300">Lain-lain (…………….sebutkan)</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4 bg-gray-100">
        <h4 class="font-semibold text-gray-800 mb-3">6. Data Pelayanan Penunjang (apabila Klinik menyelenggarakan pelayanan penunjang)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan radiologi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">2</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pemeriksaan USG</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">3</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan rehabilitasi medik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">4</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan akupunktur medik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">5</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan treadmill</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">6</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan terapi ozon</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">7</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pelayanan terapi alternatif</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">8</td>
                        <td class="px-3 py-2 border border-gray-300">Lain-lain (…………….sebutkan)</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4 bg-gray-50">
        <h4 class="font-semibold text-gray-800 mb-3">7. Data Pelayanan Kefarmasian (apabila Klinik menyelenggarakan pelayanan farmasi)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">Data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah pengkajian dan pelayanan resep</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">2</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah konseling</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">3</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah Pelayanan Informasi Obat (PIO)</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4 bg-gray-100">
        <h4 class="font-semibold text-gray-800 mb-3">8. Data Pelayanan Estetika (apabila Klinik menyelenggarakan pelayanan Estetika)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Akne</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">2</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Parut Akne</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">3</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Hiperpigmentasi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">4</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Penuaan Kulit</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">5</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Nevus</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">6</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Keratoris Seborik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">7</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Veruka/Kutil</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">8</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Bau Badan</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">9</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Hiperhidrosis</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">10</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Selulit</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">11</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Strecth Mark</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">12</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Kerontokan Rambut</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">13</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Ketombe</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">14</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Keloid</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">15</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Tatto</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">16</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Hirsutisme</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">17</td>
                        <td class="px-3 py-2 border border-gray-300">Jumlah perawatan Obesitas</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">18</td>
                        <td class="px-3 py-2 border border-gray-300">Lain-lain (…………….sebutkan)</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4 bg-gray-50">
        <h4 class="font-semibold text-gray-800 mb-3">9. Data Tindakan Medik Pelayanan Estetika (apabila Klinik menyelenggarakan pelayanan Estetika)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="table-header-gradient">
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap" style="width: 50px;">No</th>
                        <th class="px-3 py-3 border border-gray-300 font-bold whitespace-nowrap">Kegiatan</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">L</th>
                        <th class="px-3 py-3 text-center border border-gray-300 font-bold whitespace-nowrap">P</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">1</td>
                        <td class="px-3 py-2 border border-gray-300">Facial</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">2</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">a. manual</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">3</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">b. mekanik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">4</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">c. elektrik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">5</td>
                        <td class="px-3 py-2 border border-gray-300">Perawatan Badan</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">6</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">a. manual</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">7</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">b. mekanik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">8</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">c. elektrik</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">9</td>
                        <td class="px-3 py-2 border border-gray-300">Dermabrasi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">10</td>
                        <td class="px-3 py-2 border border-gray-300">Mikrodermabrasi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">11</td>
                        <td class="px-3 py-2 border border-gray-300">Chemical Peeling</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">12</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">- superfisial</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">13</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">- medium</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">14</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">- deep</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">15</td>
                        <td class="px-3 py-2 border border-gray-300">Dengan Laser</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">16</td>
                        <td class="px-3 py-2 border border-gray-300">Dengan IPL</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">17</td>
                        <td class="px-3 py-2 border border-gray-300">Dengan LHE</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">18</td>
                        <td class="px-3 py-2 border border-gray-300">Dengan Cauter</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">19</td>
                        <td class="px-3 py-2 border border-gray-300">Filler Augmentasi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">20</td>
                        <td class="px-3 py-2 border border-gray-300">Mesoterapi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">21</td>
                        <td class="px-3 py-2 border border-gray-300">Tindakan Operasi</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">22</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">1. …............</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">23</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">2. …............</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">24</td>
                        <td class="px-3 py-2 border border-gray-300 pl-8">3. dst</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">25</td>
                        <td class="px-3 py-2 border border-gray-300">Liposuction</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">26</td>
                        <td class="px-3 py-2 border border-gray-300">Suntik Botox</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">27</td>
                        <td class="px-3 py-2 border border-gray-300">Implan</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-center border border-gray-300">28</td>
                        <td class="px-3 py-2 border border-gray-300">Lain-lain (…………….sebutkan)</td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                        <td class="px-3 py-2 text-center border border-gray-300 bg-gray-50"></td>
                    </tr>
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="2" class="px-3 py-2 text-right border border-gray-400">Total</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                        <td class="px-3 py-2 text-center border border-gray-400">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-6">
        <h4 class="font-bold text-blue-900 mb-3">Keterangan:</h4>
        <ol class="list-decimal list-inside text-sm text-blue-800 space-y-2">
            <li><strong>Program Nasional</strong>: HIV, Stunting & Wasting, TB, KB, Peningkatan Kesehatan Ibu dan Bayi</li>
            <li><strong>Kunjungan Baru</strong>: Pasien yang pertama kali datang ke Klinik Utama untuk mendapatkan pelayanan kesehatan di tahun berjalan</li>
            <li><strong>Kunjungan Lama</strong>: Pasien yang datang ke Klinik Utama lebih dari 1 kali untuk mendapatkan pelayanan kesehatan di tahun berjalan</li>
            <li>Untuk data jumlah mohon diisi dengan angka agar tidak merusak rumus penghitungan</li>
            <li>Mohon tidak menambah baris baru agar tidak merusak rumus penghitungan, dan jika ada penambahan pelayanan atau tindakan bisa ditambahkan di kolom lain-lain dengan menuliskan tambahannya di dalam kurung</li>
        </ol>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx-js-style.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>
<script>
    async function exportExcelFull() {
        // Ensure XLSX is available
        if (typeof XLSX === 'undefined') {
            alert('Library Excel belum siap. Mohon reload halaman.');
            return;
        }
        var btn = event.currentTarget;
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-hourglass-split me-2 animate-spin"></i> Loading...';
        btn.disabled = true;

        try {
            // Fetch data from server (All Months)
            var allData = await window.Livewire.find('<?php echo e($_instance->getId()); ?>').getAllMonthsExportData();

            var wb = XLSX.utils.book_new();
            var hasData = false;

            // Define header style
            const borderStyle = {
                top: { style: "thin", color: { auto: 1 } },
                bottom: { style: "thin", color: { auto: 1 } },
                left: { style: "thin", color: { auto: 1 } },
                right: { style: "thin", color: { auto: 1 } }
            };

            // Loop through each month (key = Sheet Name)
            Object.keys(allData).forEach(function(sheetName) {
                var sheetData = allData[sheetName];
                if (sheetData && sheetData.length > 0) {
                    var ws = XLSX.utils.aoa_to_sheet(sheetData);

                    // Add Widths
                    ws['!cols'] = [
                        { wch: 5 },  // No
                        { wch: 40 }, // Uraian / Nama
                        { wch: 15 }, // Data / L
                        { wch: 15 }, // P
                        { wch: 15 }, // Total
                        { wch: 15 }, // Info
                        { wch: 15 },
                        { wch: 15 },
                        { wch: 15 }
                    ];

                    // Add Borders to all cells
                    var range = XLSX.utils.decode_range(ws['!ref']);
                    for(var R = range.s.r; R <= range.e.r; ++R) {
                        for(var C = range.s.c; C <= range.e.c; ++C) {
                            var cell_address = XLSX.utils.encode_cell({r:R, c:C});
                            if(!ws[cell_address]) continue;

                            // Apply Style
                            if (!ws[cell_address].s) ws[cell_address].s = {};
                            ws[cell_address].s.border = borderStyle;
                        }
                    }

                    XLSX.utils.book_append_sheet(wb, ws, sheetName);
                    hasData = true;
                }
            });

            if (hasData) {
                XLSX.writeFile(wb, "Laporan_Klinik_Full_" + "<?php echo e($year); ?>" + ".xlsx");
            } else {
                alert('Tidak ada data untuk diexport.');
            }
        } catch (error) {
            console.error('Export Error:', error);
            alert('Terjadi kesalahan saat export data: ' + error);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }

    function exportPdfFull() {
        var element = document.getElementById('report-container'); // Main container
        var reportTitle = "Laporan_Klinik_<?php echo e($selectedMonth); ?>_<?php echo e($year); ?>";

        if (!element) {
             alert("Gagal export PDF: Element #report-container tidak ditemukan.");
             return;
        }

        // Show loading state if needed
        var btn = event.currentTarget;
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-hourglass-split me-2 animate-spin"></i> Processing...';
        btn.disabled = true;

        // Configuration to bypass CORS issues:
        // 1. fontEmbedCSS: '' skips font embedding
        // 2. filter: excludes <link> tags so it doesn't try to fetch stylesheets
        htmlToImage.toPng(element, {
            backgroundColor: '#ffffff',
            fontEmbedCSS: '',
            filter: function(node) {
                // Return false to exclude the node from processing
                // Exclude link tags to prevent fetching external CSS avoiding CORS
                if (node.tagName === 'LINK') return false;
                return true;
            }
        })
          .then(function (dataUrl) {
            // A4 size settings
            var pdf = new jspdf.jsPDF('p', 'mm', 'a4');
            var imgWidth = 210;
            var pageHeight = 297;

            var img = new Image();
            img.src = dataUrl;

            img.onload = function() {
                var imgHeight = img.height * imgWidth / img.width;
                var heightLeft = imgHeight;
                var position = 0;

                pdf.addImage(dataUrl, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                  position = heightLeft - imgHeight;
                  pdf.addPage();
                  pdf.addImage(dataUrl, 'PNG', 0, position, imgWidth, imgHeight);
                  heightLeft -= pageHeight;
                }

                pdf.save(reportTitle + '.pdf');

                // Restore button
                btn.innerHTML = originalText;
                btn.disabled = false;
            };
        })
        .catch(function (error) {
            console.error('Export PDF Error:', error);
            // Try to extract useful info from Event object if generic
            var errorMsg = error.message || (error.type ? "Network/CORS Error (" + error.type + ")" : JSON.stringify(error));
            if (errorMsg === '{}') errorMsg = "Unknown Error (likely CORS from external resources)";

            alert("Gagal export PDF: " + errorMsg);
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/report/activity/admin-report-activity-index.blade.php ENDPATH**/ ?>