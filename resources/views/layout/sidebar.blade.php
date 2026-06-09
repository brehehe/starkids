<!-- Sidebar Container with Flex Structure -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 flex flex-col bg-white/80 backdrop-blur-sm w-64 border-r border-gray-100 shadow-lg z-40 transition-transform duration-300 ease-in-out transform translate-x-0">
    <!-- Sidebar content -->

    <!-- Logo Section -->
    <div class="flex-shrink-0 h-16 flex items-center gap-3 px-6 border-b border-gray-100 overflow-hidden">
        <div class="flex items-center gap-3 whitespace-nowrap">
            <h2 class="text-lg font-bold text-[#1E3A8A]">-</h2>
            <p class="text-xs text-gray-500">Healthcare System</p>
        </div>
    </div>

    <!-- Scrollable Menu Section -->
    <div class="flex-1 overflow-y-auto" id="sidebar-menu">
        <div class="p-2">
            <nav class="space-y-1">
                <!-- Dashboard -->
                <div>
                    <a href="/user"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                        <div class="flex items-center gap-3">
                            <i
                                class="fa fa-house mr-2 text-lg {{ Request::is('user') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                            <span class="sidebar-text">Dashboard</span>
                        </div>
                    </a>
                </div>

                <!-- Notifications -->
                <div>
                    <a href="{{ route('user.notifications.list') }}"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/notifications/list*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                        <div class="flex items-center gap-3">
                            <i
                                class="fa-solid fa-bell mr-2 text-lg {{ Request::is('user/notifications/list*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                            <span class="sidebar-text">Notifikasi</span>
                        </div>
                    </a>
                </div>

                <!-- Divider: MENU PEMBELIAN -->
                @if (auth()->user()->hasRole(['Super Admin', 'Resepsionis', 'Kasir', 'Perawat']))
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Konsultasi
                        </div>
                    </div>
                    <div>
                        <a href="/user/consultation/patient"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/patient*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-user mr-2 text-lg {{ Request::is('user/consultation/patient*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pasien</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/consultation/queue"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/queue*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-user-clock mr-2 text-lg {{ Request::is('user/consultation/queue*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Antrian</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/consultation/consultation"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/consultation*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-stethoscope mr-2 text-lg {{ Request::is('user/consultation/consultation*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Konsultasi</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/consultation/history"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/history*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clock-rotate-left mr-2 text-lg {{ Request::is('user/consultation/history*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Histori Konsultasi</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/consultation/claim-insurance"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/claim-insurance*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-shield mr-2 text-lg {{ Request::is('user/consultation/claim-insurance*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Klaim Asuransi</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/consultation/date-control"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/date-control*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-calendar mr-2 text-lg {{ Request::is('user/consultation/date-control*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jadwal Kontrol</span>
                            </div>
                        </a>
                    </div>
                @endif
                @if (auth()->user()->hasRole(['Dokter']))
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Konsultasi
                        </div>
                    </div>
                    <div>
                        <a href="/user/consultation/consultation"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/consultation*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-stethoscope mr-2 text-lg {{ Request::is('user/consultation/consultation*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Konsultasi</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/consultation/history"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/history*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clock-rotate-left mr-2 text-lg {{ Request::is('user/consultation/history*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Histori Konsultasi</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/consultation/date-control"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/consultation/date-control*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clock-rotate-left mr-2 text-lg {{ Request::is('user/consultation/date-control*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jadwal Kontrol</span>
                            </div>
                        </a>
                    </div>
                @endif
                @if (auth()->user()->hasRole(['Super Admin', 'Apoteker']))
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Logistik
                        </div>
                    </div>
                    <div>
                        <a href="/user/purchase/defecta"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/purchase/defecta') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa fa-lightbulb mr-2 text-lg {{ Request::is('user/purchase/defecta') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Defecta</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/purchase/draft-mail-order"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/purchase/draft-mail-order') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa fa-file-lines mr-2 text-lg {{ Request::is('user/purchase/draft-mail-order') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Draft Surat Pesanan</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/purchase/mail-order"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/purchase/mail-order*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-envelope-open-text mr-2 text-lg {{ Request::is('user/purchase/mail-order*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Surat Pesanan</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/direct-purchase"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/direct-purchase*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-envelope mr-2 text-lg {{ Request::is('user/logistic/direct-purchase*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pembelian Langsung</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/good-come"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/good-come*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-check-circle mr-2 text-lg {{ Request::is('user/logistic/good-come*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Penerimaan Barang</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/return"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/return*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-envelope mr-2 text-lg {{ Request::is('user/logistic/return*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Retur Pembelian</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/product-stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/product-stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-warehouse mr-2 text-lg {{ Request::is('user/logistic/product-stock*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Stok Produk</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/stock-in"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/stock-in*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <svg width="16px" height="19px" class="mr-2" viewBox="0 0 24 24"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"
                                    fill="{{ Request::is('user/logistic/stock-in*') ? '#1E3A8A' : '#C3D4EC' }}">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g transform="translate(0 -1028.4)">
                                            <path d="m3.1875 6l-2 10h2v-7h18v7h2l-2-10h-18z" transform="translate(0 1028.4)"
                                                fill="#fffff39c12"></path>
                                            <path d="m3.1875 1037.4-2 14h2 18 2l-2-14h-18z" fill="#ffff"></path>
                                            <path
                                                d="m9 1030.4v5h-3v0.9 0.1h0.0312l5.9688 6.5 5.969-6.5 0.031-0.1v-0.9h-3v-5h-6z"
                                                fill="#ffff"></path>
                                            <path
                                                d="m1.1875 1044.4v7h22v-7h-8.188c-0.416 1.1-1.511 2-2.812 2-1.302 0-2.3975-0.9-2.813-2h-8.1875z"
                                                fill="#fffff1c40f"></path>
                                            <rect height="1" width="22" y="1051.4" x="1.1875" fill="#fffff39c12"></rect>
                                            <path d="m9 0v1 5.9688h-3l6 6.5312 6-6.5312h-3v-5.9688-1h-6z"
                                                transform="translate(0 1028.4)" fill="#ffff34495e"></path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="sidebar-text">Stok Masuk</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/stock-out"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/stock-out*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <svg width="16px" height="19px" class="mr-2" viewBox="0 0 24 24"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"
                                    fill="{{ Request::is('user/logistic/stock-out*') ? '#1E3A8A' : '#C3D4EC' }}">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g transform="translate(0 -1028.4)">
                                            <path d="m3.1875 6l-2 10h2v-5h18v5h2l-2-10h-18z" transform="translate(0 1028.4)"
                                                fill="#fffff39c12"></path>
                                            <path d="m3.1875 1038.4-2 13h2 18 2l-2-13h-18z" fill="#ffff"></path>
                                            <path
                                                d="m1.1875 1044.4v7h22v-7h-8.188c-0.416 1.1-1.511 2-2.812 2-1.302 0-2.3975-0.9-2.813-2h-8.1875z"
                                                fill="#fffff1c40f"></path>
                                            <path d="m6 7v1h12v-1h-12zm3 6v1h6v-1h-6z" transform="translate(0 1028.4)"
                                                fill="#ffff2c3e50"></path>
                                            <rect height="1" width="22" y="1051.4" x="1.1875" fill="#fffff39c12"></rect>
                                            <path d="m9 1041.4v-6h-3l6-6.5 6 6.5h-3v6h-6z" fill="#ffff34495e"></path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="sidebar-text">Stok Keluar</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/import-stock-product"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/import-stock-product*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-box-open mr-2 text-lg {{ Request::is('user/logistic/import-stock-product*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Import Stok Barang</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/logistic/stock-product"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/stock-product*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-pen-to-square mr-2 text-lg {{ Request::is('user/logistic/stock-product*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Stock Opname</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/dead-stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/dead-stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-skull-crossbones mr-2 text-lg {{ Request::is('user/logistic/dead-stock*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Dead Stock</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/expired-date"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/expired-date*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-calendar mr-2 text-lg {{ Request::is('user/logistic/expired-date*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Expired Date</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/replace-product"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/replace-product*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-arrow-right mr-2 text-lg {{ Request::is('user/logistic/replace-product*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Sesuaikan Produk</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/logistic/product-adjustment"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/product-adjustment*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-tools mr-2 text-lg {{ Request::is('user/logistic/product-adjustment*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Perbaikan Stok & Harga</span>
                            </div>
                        </a>
                    </div>

                    {{-- <div>
                        <a href="/user/logistic/stock-mutation"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/logistic/stock-mutation*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-arrow-right mr-2 text-lg {{ Request::is('user/logistic/stock-mutation*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Mutasi Stok</span>
                            </div>
                        </a>
                    </div> --}}
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Instalasi Farmasi
                        </div>
                    </div>


                    <div>
                        <a href="/user/pharmacy/price"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/pharmacy/price*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-bill-wave mr-2 text-lg {{ Request::is('user/pharmacy/price*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Update Harga Jual</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/pharmacy/product-price"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/pharmacy/product-price*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-check-dollar mr-2 text-lg {{ Request::is('user/pharmacy/product-price*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Harga Jual</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/pharmacy/consultation"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/pharmacy/consultation*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-stethoscope mr-2 text-lg {{ Request::is('user/pharmacy/consultation*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Konsultasi</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/sale/pos"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/sale/pos*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-cash-register mr-2 text-lg {{ Request::is('user/sale/pos*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">POS</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/pharmacy/take-medicine"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/pharmacy/take-medicine*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-pills mr-2 text-lg {{ Request::is('user/pharmacy/take-medicine*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pengambilan Obat</span>
                            </div>
                        </a>
                    </div>
                @endif
                @if (auth()->user()->hasRole(['Super Admin', 'Kasir']))
                    <!-- Divider: Kasir -->
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Kasir
                        </div>
                    </div>

                    <div>
                        <a href="/user/sale/price"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/sale/price*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-bill-wave mr-2 text-lg {{ Request::is('user/sale/price*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Update Harga Jual</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/sale/product-price"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/sale/product-price*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-check-dollar mr-2 text-lg {{ Request::is('user/sale/product-price*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Harga Jual</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/sale/pos"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/sale/pos*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-cash-register mr-2 text-lg {{ Request::is('user/sale/pos*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">POS</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/sale/pending"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/sale/pending*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clock mr-2 text-lg {{ Request::is('user/sale/pending*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pending</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/sale/claim-insurance"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/sale/claim-insurance*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-shield mr-2 text-lg {{ Request::is('user/sale/claim-insurance*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Klaim Asuransi</span>
                            </div>
                        </a>
                    </div>
                @endif


                @if (auth()->user()->hasRole(['Super Admin', 'Finance']))

                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Finance
                        </div>
                    </div>

                    {{-- <div>
                        <a href="/user/finance/cost"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/cost*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-check-dollar-pen mr-2 text-lg {{ Request::is('user/finance/cost*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Biaya</span>
                            </div>
                        </a>
                    </div> --}}
                    <div>
                        <a href="/user/finance/sale"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/sale*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-cash-register mr-2 text-lg {{ Request::is('user/finance/sale*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Penjualan</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/finance/purchase"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/purchase*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-envelope-open-text mr-2 text-lg {{ Request::is('user/finance/purchase*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pembelian</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/finance/dead-stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/dead-stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-skull-crossbones mr-2 text-lg {{ Request::is('user/finance/dead-stock*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Dead Stock</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/finance/stock-opname"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/stock-opname*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-box mr-2 text-lg {{ Request::is('user/finance/stock-opname*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Stock Opname</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/finance/finance"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/finance*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-wallet mr-2 text-lg {{ Request::is('user/finance/finance*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Keuangan</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/finance/balance-sheet"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/balance-sheet*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-scale-balanced mr-2 text-lg {{ Request::is('user/finance/balance-sheet*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Neraca Keuangan</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/finance/profit-loss"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/profit-loss*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-file-invoice-dollar mr-2 text-lg {{ Request::is('user/finance/profit-loss*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Laba Rugi</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/finance/cash-flow"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/cash-flow*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-bill-transfer mr-2 text-lg {{ Request::is('user/finance/cash-flow*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Arus Kas</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/finance/ledger"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/ledger*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-book mr-2 text-lg {{ Request::is('user/finance/ledger*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Buku Besar</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/finance/journal"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/journal*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clipboard-list mr-2 text-lg {{ Request::is('user/finance/journal*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jurnal</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/finance/general-journal"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/general-journal*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-book-open mr-2 text-lg {{ Request::is('user/finance/general-journal*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jurnal Umum</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/finance/adjustment-journal"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/finance/adjustment-journal*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-pen-to-square mr-2 text-lg {{ Request::is('user/finance/adjustment-journal*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jurnal Penyesuaian</span>
                            </div>
                        </a>
                    </div>
                @endif
                @if (auth()->user()->hasRole(['Super Admin', 'HR']))
                    <!-- Divider: HR -->
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            HR
                        </div>
                    </div>

                    <div>
                        <a href="/user/hr/employee"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/hr/employee*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-users-rectangle mr-2 text-lg {{ Request::is('user/hr/employee*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pegawai</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/hr/doctor"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/hr/doctor*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-user-doctor mr-2 text-lg {{ Request::is('user/hr/doctor*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Dokter</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/hr/attendance"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/hr/attendance*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-calendar-check mr-2 text-lg {{ Request::is('user/hr/attendance*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Absensi</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/hr/leave"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/hr/leave') && !Request::is('user/hr/leave-monitor') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-calendar-check mr-2 text-lg {{ Request::is('user/hr/leave') && !Request::is('user/hr/leave-monitor') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Cuti</span>
                            </div>
                        </a>
                    </div>

                    <!-- Monitoring HR -->
                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/hr/monitor*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('hr-monitoring')">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-desktop mr-2 text-lg {{ Request::is('user/hr/monitor*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span>Monitoring</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/hr/monitor*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="hr-monitoring-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/hr/monitor*') ? 'open' : '' }}"
                            id="hr-monitoring">
                            <a href="/user/hr/monitor/attendance"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/monitor/attendance') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/monitor/attendance') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Monitor Absensi
                            </a>
                            <a href="/user/hr/monitor/leave"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/monitor/leave') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/monitor/leave') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Monitor Cuti
                            </a>
                        </div>
                    </div>

                    <!-- Master Penggajian -->
                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/hr/master-payroll*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('hr-master-payroll')">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-cogs mr-2 text-lg {{ request()->is('user/hr/master-payroll*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span>Master Penggajian</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/hr/master-payroll*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="hr-master-payroll-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/hr/master-payroll*') ? 'open' : '' }}"
                            id="hr-master-payroll">
                            <a href="/user/hr/master-payroll/component"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/master-payroll/component') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/master-payroll/component') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Komponen Gaji (Tipe)
                            </a>
                            <a href="/user/hr/master-payroll/setting"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/master-payroll/setting') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/master-payroll/setting') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Set Gaji Pegawai
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/hr/shift*') || request()->is('user/hr/shift-setting*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('shift')">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clock mr-2 text-lg {{ request()->is('user/hr/shift*') || request()->is('user/hr/shift-setting*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span>Master Shift</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/hr/shift*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="shift-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/hr/shift*') || request()->is('user/hr/shift-setting*') ? 'open' : '' }}"
                            id="shift">
                            <a href="/user/hr/shift"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/shift') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/shift') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Master Shift
                            </a>
                            <a href="/user/hr/shift-setting"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/shift-setting*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/shift-setting*') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Set Shift Pegawai
                            </a>
                        </div>
                    </div>


                    <!-- Transaksi Penggajian -->
                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/hr/payroll*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('hr-payroll-trans')">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-check-dollar mr-2 text-lg {{ Request::is('user/hr/payroll*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span>Penggajian</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/hr/payroll*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="hr-payroll-trans-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/hr/payroll*') ? 'open' : '' }}"
                            id="hr-payroll-trans">
                            <a href="/user/hr/payroll/adjustment"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/payroll/adjustment') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/payroll/adjustment') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Potongan / Tambahan Khusus
                            </a>
                            <a href="/user/hr/payroll/generate"
                                class="group flex items-center gap-3 px-4 w-full py-2 text-sm font-medium rounded-lg {{ request()->is('user/hr/payroll/generate') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/hr/payroll/generate') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Generate Gaji
                            </a>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->hasRole(['Super Admin']))
                    <!-- Divider: Master -->
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Laporan
                        </div>
                    </div>

                    <div>
                        <a href="/user/report/activity"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/activity*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-chart-line mr-2 text-lg {{ Request::is('user/report/activity*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Aktivitas</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/report/incentive"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/incentive*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-coins mr-2 text-lg {{ Request::is('user/report/incentive*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Insentif</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-warehouse mr-2 text-lg {{ Request::is('user/report/stock*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Stok</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/in-stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/in-stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <svg width="16px" class="mr-2" height="19px" viewBox="0 0 24 24"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"
                                    fill="{{ Request::is('user/report/in-stock*') ? '#1E3A8A' : '#C3D4EC' }}">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g transform="translate(0 -1028.4)">
                                            <path d="m3.1875 6l-2 10h2v-7h18v7h2l-2-10h-18z" transform="translate(0 1028.4)"
                                                fill="#fffff39c12"></path>
                                            <path d="m3.1875 1037.4-2 14h2 18 2l-2-14h-18z" fill="#ffff"></path>
                                            <path
                                                d="m9 1030.4v5h-3v0.9 0.1h0.0312l5.9688 6.5 5.969-6.5 0.031-0.1v-0.9h-3v-5h-6z"
                                                fill="#ffff"></path>
                                            <path
                                                d="m1.1875 1044.4v7h22v-7h-8.188c-0.416 1.1-1.511 2-2.812 2-1.302 0-2.3975-0.9-2.813-2h-8.1875z"
                                                fill="#fffff1c40f"></path>
                                            <rect height="1" width="22" y="1051.4" x="1.1875" fill="#fffff39c12"></rect>
                                            <path d="m9 0v1 5.9688h-3l6 6.5312 6-6.5312h-3v-5.9688-1h-6z"
                                                transform="translate(0 1028.4)" fill="#ffff34495e"></path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="sidebar-text">Stok Masuk</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/out-stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/out-stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <svg width="16px" class="mr-2" height="19px" viewBox="0 0 24 24"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"
                                    fill="{{ Request::is('user/report/out-stock*') ? '#1E3A8A' : '#C3D4EC' }}">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g transform="translate(0 -1028.4)">
                                            <path d="m3.1875 6l-2 10h2v-5h18v5h2l-2-10h-18z" transform="translate(0 1028.4)"
                                                fill="#fffff39c12"></path>
                                            <path d="m3.1875 1038.4-2 13h2 18 2l-2-13h-18z" fill="#ffff"></path>
                                            <path
                                                d="m1.1875 1044.4v7h22v-7h-8.188c-0.416 1.1-1.511 2-2.812 2-1.302 0-2.3975-0.9-2.813-2h-8.1875z"
                                                fill="#fffff1c40f"></path>
                                            <path d="m6 7v1h12v-1h-12zm3 6v1h6v-1h-6z" transform="translate(0 1028.4)"
                                                fill="#ffff2c3e50"></path>
                                            <rect height="1" width="22" y="1051.4" x="1.1875" fill="#fffff39c12"></rect>
                                            <path d="m9 1041.4v-6h-3l6-6.5 6 6.5h-3v6h-6z" fill="#ffff34495e"></path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="sidebar-text">Stok Keluar</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/purchase"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/purchase*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-cart-shopping mr-2 text-lg {{ Request::is('user/report/purchase*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pembelian</span>
                            </div>
                        </a>
                    </div>

                    {{-- <div>
                        <a href="/user/report/return-purchase"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/return-purchase*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-arrow-circle-left mr-2 text-lg {{ Request::is('user/report/return-purchase*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Retur Pembelian</span>
                            </div>
                        </a>
                    </div> --}}

                    <div>
                        <a href="/user/report/product-purchase"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/product-purchase*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-box-open mr-2 text-lg {{ Request::is('user/report/product-purchase*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pembelian Produk</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/goods-come"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/goods-come*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-truck mr-2 text-lg {{ Request::is('user/report/goods-come*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Penerimaan Barang</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/sale"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/sale*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-cash-register mr-2 text-lg {{ Request::is('user/report/sale*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Penjualan</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/type-recipe"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/type-recipe') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-tablets mr-2 text-lg {{ Request::is('user/report/type-recipe') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Biaya Jasa</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/report/odontogram"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/odontogram') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-teeth mr-2 text-lg {{ Request::is('user/report/odontogram') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Odontogram</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/doctor-patient"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/doctor-patient*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-user-doctor mr-2 text-lg {{ Request::is('user/report/doctor-patient*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pasien per Dokter</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/report/polyclinic"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/polyclinic*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-hospital-user mr-2 text-lg {{ Request::is('user/report/polyclinic*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Kunjungan Poliklinik</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/product-sale"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/product-sale*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-boxes mr-2 text-lg {{ Request::is('user/report/product-sale*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Penjualan Produk</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/action"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/action*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-heart-pulse mr-2 text-lg {{ Request::is('user/report/action*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Tindakan</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/payment"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/payment*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-bill-wave mr-2 text-lg {{ Request::is('user/report/payment*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Terima Bayar</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/profit-loss"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/profit-loss*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-file-invoice-dollar mr-2 text-lg {{ Request::is('user/report/profit-loss*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Laba Rugi</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/dead-stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/dead-stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-skull-crossbones mr-2 text-lg {{ Request::is('user/report/dead-stock*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Dead Stock</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/opname-stock"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/opname-stock*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clipboard-check mr-2 text-lg {{ Request::is('user/report/opname-stock*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Stock Opname</span>
                            </div>
                        </a>
                    </div>

                    <div>
                        <a href="/user/report/product-stock-opname"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/report/product-stock-opname*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-clipboard-list mr-2 text-lg {{ Request::is('user/report/product-stock-opname*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Stock Opname Produk</span>
                            </div>
                        </a>
                    </div>
                @endif
                @if (auth()->user()->hasRole(['Super Admin']))
                    <!-- Divider: Master -->
                    <div>
                        <div
                            class="w-full group flex items-center justify-between custom-padding text-xs font-bold text-[#1E3A8A] uppercase tracking-wide">
                            Master
                        </div>
                    </div>
                    <!-- Registration -->
                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/master/product*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('master-product')">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 mr-2 {{ request()->is('user/master/product*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5M9 21V12h6v9" />
                                </svg>
                                <span>Produk</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/master/product*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="master-product-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/master/product*') ? 'open' : '' }}"
                            id="master-product">
                            <a href="/user/master/product/detail"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/product/detail', 'user/master/product/detail/data') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/product/detail', 'user/master/product/detail/data') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Detail Produk
                            </a>
                            <a href="/user/master/product/package"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/product/package', 'user/master/product/package/data') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/product/package', 'user/master/product/package/data') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Paket Produk
                            </a>
                            <a href="/user/master/product/category"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/product/category') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/product/category') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Kategori Produk
                            </a>
                            <a href="/user/master/product/factory"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/product/factory') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/product/factory') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Pabrik Produk
                            </a>
                            <a href="/user/master/product/rack"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/product/rack') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/product/rack') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Rak Produk
                            </a>
                            <a href="/user/master/product/unit"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/product/unit') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/product/unit') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Satuan Produk
                            </a>
                        </div>
                    </div>

                    <!-- Article Menu -->
                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/master/article*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('master-article')">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 mr-2 {{ request()->is('user/master/article*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span>Artikel</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/master/article*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="master-article-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/master/article*') ? 'open' : '' }}"
                            id="master-article">
                            <a href="{{ route('user.master.article.index') }}"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.master.article.index', 'user.master.article.create', 'user.master.article.edit') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->routeIs('user.master.article.index', 'user.master.article.create', 'user.master.article.edit') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Daftar Artikel
                            </a>
                            <a href="{{ route('user.master.article.category') }}"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.master.article.category') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->routeIs('user.master.article.category') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Kategori Artikel
                            </a>
                        </div>
                    </div>

                    <!-- Banner Menu -->
                    <div>
                        <a href="{{ route('user.master.banner.index') }}"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('user.master.banner.index') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-flag mr-2 text-lg {{ request()->routeIs('user.master.banner.index') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Banner</span>
                            </div>
                        </a>
                    </div>

                    {{-- <div>
                        <a href="/user/master/deposit"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/deposit*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-money-bill-transfer mr-2 text-lg {{ Request::is('user/master/deposit*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Deposit</span>
                            </div>
                        </a>
                    </div> --}}

                    <div>
                        <a href="/user/master/action"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/action*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-stethoscope mr-2 text-lg {{ Request::is('user/master/action*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Tindakan</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/master/service"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/service*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-briefcase mr-2 text-lg {{ Request::is('user/master/service*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jasa</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/master/medicine-type"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/medicine-type*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-tablets mr-2 text-lg {{ Request::is('user/master/medicine-type*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jenis Resep</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/master/account*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('master-account')">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-scale-balanced mr-2 text-lg {{ Request::is('user/master/account*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span>Akun Biaya</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/master/account*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="master-account-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/master/account*') ? 'open' : '' }}"
                            id="master-account">
                            <a href="/user/master/account/account"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/account/account') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/account/account') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Akun Biaya
                            </a>
                            <a href="/user/master/account/category-account"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/account/category-account') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/account/category-account') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Kategori Akun Biaya
                            </a>
                        </div>
                    </div>
                    <div>
                        <a href="/user/master/poly"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/poly*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-hospital-alt mr-2 text-lg {{ Request::is('user/master/poly*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Poli</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/master/insurance"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/insurance*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-shield mr-2 text-lg {{ Request::is('user/master/insurance*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Asuransi</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/master/doctor-control"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/doctor-control') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-calendar mr-2 text-lg {{ Request::is('user/master/doctor-control') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Jadwal Doktor</span>
                            </div>
                        </a>
                    </div>
                    {{-- <div>
                        <a href="/user/master/how-to-use"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/how-to-use') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-hourglass-half mr-2 text-lg {{ Request::is('user/master/how-to-use') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Aturan Pakai</span>
                            </div>
                        </a>
                    </div> --}}
                    <div>
                        <a href="/user/master/supplier"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/supplier') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <!-- Users Icon -->
                                <svg class="w-5 h-5 mr-2 {{ Request::is('user/master/supplier') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }} shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-7a4 4 0 11-8 0 4 4 0 018 0zM12 14a4 4 0 00-4 4v2h8v-2a4 4 0 00-4-4z" />
                                </svg>
                                <span class="sidebar-text">Supplier</span>
                            </div>
                        </a>
                    </div>
                    {{-- <div>
                        <a href="/user/master/discount"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/discount') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-percent mr-2 text-lg {{ Request::is('user/master/discount*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Diskon</span>
                            </div>
                        </a>
                    </div> --}}
                    <div>
                        <a href="/user/promotion"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/promotion*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-bullhorn mr-2 text-lg {{ Request::is('user/promotion*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Promo</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/master/icd"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/icd') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-disease mr-2 text-lg {{ Request::is('user/master/icd*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">ICD</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/master/payment-method"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/payment-method') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-credit-card-alt mr-2 text-lg {{ Request::is('user/master/payment-method') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Metode Pembayaran</span>
                            </div>
                        </a>
                    </div>
                    {{-- @if (Auth::user()->company->is_main)
                    <div>
                        <a href="/user/master/service-month"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/service-month') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-tags mr-2 text-lg {{ Request::is('user/master/service-month') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Service</span>
                            </div>
                        </a>
                    </div>
                    @endif --}}
                    <div>
                        <a href="/user/master/patient"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/patient') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-user mr-2 text-lg {{ Request::is('user/master/patient') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Pasien</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/family"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/family*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-users mr-2 text-lg {{ Request::is('user/family*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Keluarga</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <button type="button"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg cursor-pointer {{ request()->is('user/master/user-type*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200"
                            onclick="togglemenu('user-type')">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-user-tag mr-2 text-lg {{ Request::is('user/master/user-type*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span>Tipe Pasien</span>
                            </div>
                            <svg class="w-4 h-4 menu-arrow {{ request()->is('user/master/user-type*') ? 'rotate text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"
                                id="user-type-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="submenu p-1 pl-2 space-y-1 {{ request()->is('user/master/user-type*') ? 'open' : '' }}"
                            id="user-type">
                            <a href="/user/master/user-type/user-type"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/user-type/user-type') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/user-type/user-type') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Tipe Pasien
                            </a>
                            <a href="/user/master/user-type/incentive"
                                class="group flex items-center gap-3 px-4 w-full  py-2 text-sm font-medium rounded-lg {{ request()->is('user/master/user-type/incentive') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                                <span
                                    class="w-1.5 h-1.5 mr-2 {{ request()->is('user/master/user-type/incentive') ? 'bg-[#1E3A8A]' : 'bg-gray-400 group-hover:bg-[#1E3A8A]' }} rounded-full"></span>
                                Insentif
                            </a>
                        </div>
                    </div>

                    <div>
                        <a href="/user/master/doctor"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/doctor') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-user-md mr-2 text-lg {{ Request::is('user/master/doctor') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Dokter</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="/user/master/user"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/user') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-users mr-2 text-lg {{ Request::is('user/master/user') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">User</span>
                            </div>
                        </a>
                    </div>
                    {{-- <div>
                        <a href="/user/master/role"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/role') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-tag mr-2 text-lg {{ Request::is('user/master/role') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Role</span>
                            </div>
                        </a>
                    </div> --}}
                    <div>
                        <a href="/user/master/print"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/print*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-print mr-2 text-lg {{ Request::is('user/master/print*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Print</span>
                            </div>
                        </a>
                    </div>
                    {{-- <div>
                        <a href="/user/master/company"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/company*') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid fa-warehouse mr-2 text-lg {{ Request::is('user/master/company*') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }}"></i>
                                <span class="sidebar-text">Cabang</span>
                            </div>
                        </a>
                    </div> --}}
                    <div>
                        <a href="/user/master/setting"
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ Request::is('user/master/setting') ? 'bg-[#C3D4EC]/50 text-[#1E3A8A] active-menu' : 'text-gray-600 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A]' }} transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 mr-2 {{ Request::is('user/master/setting') ? 'text-[#1E3A8A]' : 'text-gray-400 group-hover:text-[#1E3A8A]' }} shrink-0"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3" />
                                    <path
                                        d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33h.09a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v.09a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                                </svg>

                                <span class="sidebar-text">Pengaturan</span>
                            </div>
                        </a>
                    </div>
                @endif
            </nav>
        </div>
    </div>
</aside>