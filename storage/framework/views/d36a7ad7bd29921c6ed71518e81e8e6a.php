<nav class="bg-white/80 backdrop-blur-sm border-b border-gray-100 fixed !top-0 !left-0 !right-0 w-full z-50 shadow-sm">
    <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex justify-between h-16">
            <!-- Left Section: Sidebar Toggle & Logo -->
            <div class="flex items-center gap-3">
                <button id="toggleSidebar"
                    class="p-2 rounded-xl text-[#1E3A8A] hover:bg-[#C3D4EC]/20 transition-all duration-200 cursor-pointer">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <img src="<?php echo e(Auth::user()?->company?->logo ? asset('storage/' . Auth::user()->company->logo) : asset('asset/img/logo.png')); ?>"
                    alt="<?php echo e(config('app.name')); ?> Logo" class="h-7 w-auto">
            </div>

            <!-- Right Section: Actions -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Mobile Company Info Button -->
                <div class="xl:hidden flex items-center">
                    <div x-data="{ open: false }" class="relative"
                        @mouseenter="if(window.innerWidth>=1280){ open = true }"
                        @mouseleave="if(window.innerWidth>=1280){ open = false }">
                        <button @click="open = !open"
                            class="p-2 rounded-xl text-[#1E3A8A] hover:bg-[#C3D4EC]/20 transition-all duration-200">
                            <i class="fas fa-building text-lg"></i>
                        </button>
                        <!-- Mobile Company Info Dropdown -->
                        <div x-show="open" x-transition @click.away="open = false"
                            class="absolute right-0 mt-2 w-72 sm:w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-50">
                            <div class="p-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="fas fa-building text-blue-600"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">
                                            <?php echo e(auth()->user()?->company?->name ?? 'Nama Perusahaan'); ?>

                                        </p>
                                    </div>
                                </div>
                                <hr class="mb-3 border-gray-100">
                                <div class="flex items-center gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()?->company?->is_lifetime): ?>
                                        <i class="fas fa-infinity text-green-500"></i>
                                        <div>
                                            <p class="text-xs text-green-600 font-medium">Status: Seumur Hidup</p>
                                        </div>
                                    <?php elseif(Auth::user()?->company): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isExpired ?? false): ?>
                                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                                            <div>
                                                <p class="text-xs text-red-600 font-medium">Status: EXPIRED</p>
                                                <p class="text-xs text-red-500"><?php echo e(abs($daysLeft)); ?> hari yang lalu</p>
                                            </div>
                                        <?php elseif($isExpiringSoon ?? false): ?>
                                            <i class="fas fa-clock text-orange-500"></i>
                                            <div>
                                                <p class="text-xs text-orange-600 font-medium">Berakhir Dalam</p>
                                                <p class="text-xs text-orange-500"><?php echo e($daysLeft); ?> hari lagi</p>
                                            </div>
                                        <?php else: ?>
                                            <i class="fas fa-calendar-check text-green-500"></i>
                                            <div>
                                                <p class="text-xs text-green-600 font-medium">Aktif Hingga</p>
                                                <p class="text-xs text-green-500">
                                                    <?php echo e(isset($expiredDate) ? \Carbon\Carbon::parse($expiredDate)->format('d M Y') : 'N/A'); ?>

                                                </p>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php else: ?>
                                        <i class="fas fa-exclamation-circle text-gray-500"></i>
                                        <div>
                                            <p class="text-xs text-gray-600 font-medium">Tidak ada perusahaan terkait</p>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div x-data="{
                    open: false,
                    notifications: [],
                    unreadCount: 0,
                    fetchNotifications() {
                        fetch('<?php echo e(route('user.notifications.index')); ?>',{
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                this.notifications = data.notifications || [];
                                this.unreadCount = data.unreadCount || 0;
                            })
                            .catch(err => {
                                console.error('Error fetching notifications:', err);
                                this.notifications = [];
                                this.unreadCount = 0;
                            });
                    },
                    markAsRead(id) {
                        const notification = this.notifications.find(n => n.id === id);
                        fetch(`/api/notifications/${id}/read`, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                this.fetchNotifications();
                                if (notification?.data?.action_url) {
                                    window.location.href = notification.data.action_url;
                                }
                            }
                        })
                        .catch(err => console.error('Error marking as read:', err));
                    },
                    markAllAsRead() {
                        fetch('<?php echo e(route('user.notifications.mark-all-read')); ?>', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || ''
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                this.fetchNotifications();
                            }
                        })
                        .catch(err => console.error('Error marking all as read:', err));
                    },
                    formatDate(dateStr) {
                        const date = new Date(dateStr);
                        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                    }
                }" x-init="fetchNotifications();
                setInterval(() => fetchNotifications(), 30000)" class="relative"
                    @mouseenter="if(window.innerWidth >= 1280){ open = true }"
                    @mouseleave="if(window.innerWidth >= 1280){ open = false }">
                    <button @click="open = !open"
                        class="p-2 rounded-xl text-gray-500 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A] transition-all duration-200 relative">
                        <i class="fas fa-bell text-lg"></i>
                        <template x-if="unreadCount > 0">
                            <span
                                class="absolute top-1 right-1 h-4 w-4 bg-red-500 rounded-full text-[10px] text-white flex items-center justify-center"
                                x-text="unreadCount"></span>
                        </template>
                    </button>

                    <div x-show="open" x-transition @click.away="open = false"
                        class="absolute right-0 mt-2 w-72 sm:w-96 bg-white border border-gray-200 rounded-xl shadow-lg z-50">
                        <div class="p-4 font-semibold text-gray-700 border-b">Notifikasi</div>
                        <ul id="notif-list" class="max-h-96 overflow-y-auto divide-y divide-gray-100">
                            <template x-for="notif in notifications" :key="notif.id">
                                <li class="hover:bg-gray-100 cursor-pointer border-b last:border-0 relative">
                                    <a @click="markAsRead(notif.id)" class="block p-3 w-full h-full text-left">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <i class="fas fa-box text-blue-500 text-sm"
                                                    x-show="notif.type === 'product_expiry'"></i>
                                                <i class="fas fa-exclamation-triangle text-orange-500 text-sm"
                                                    x-show="notif.type === 'defecta'"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-semibold text-sm text-gray-800" x-text="notif.title">
                                                </div>
                                                <div class="text-xs text-gray-600 mt-1 line-clamp-2"
                                                    x-text="notif.message"></div>
                                                <div class="text-[10px] text-gray-400 mt-1"
                                                    x-text="formatDate(notif.created_at)"></div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </template>
                            <template x-if="!notifications || notifications.length === 0">
                                <li class="p-6 text-gray-500 text-sm text-center">
                                    <i class="fas fa-bell-slash text-3xl text-gray-300 mb-2"></i>
                                    <p>Tidak ada notifikasi</p>
                                </li>
                            </template>
                        </ul>
                        <div class="p-2 border-t bg-gray-50 rounded-b-xl">
                            <button @click="markAllAsRead()"
                                class="w-full py-2 text-sm text-center text-blue-600 font-medium hover:text-blue-800 transition-colors">
                                Tandai Semua Dibaca
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative cursor-pointer"
                    @mouseenter="if(window.innerWidth>=1280){ open = true }"
                    @mouseleave="if(window.innerWidth>=1280){ open = false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 sm:gap-3 p-2 rounded-xl hover:bg-[#C3D4EC]/20 transition-all duration-200">
                        <!-- Profile Image -->
                        <div class="h-8 w-8 rounded-lg overflow-hidden bg-white flex items-center justify-center">
                            <img src="<?php echo e(auth()->user()->profile ? asset('storage/' . auth()->user()->profile) : asset('asset/img/profile.png')); ?>"
                                alt="Profile" class="h-full w-full object-cover">
                        </div>
                        <!-- Profile Info (Hidden on small screens) -->
                        <div class="hidden sm:block text-left whitespace-nowrap">
                            <p class="text-sm font-medium text-gray-900 truncate max-w-[150px] lg:max-w-none">
                                <?php echo e(auth()->user()->name ?? 'Admin User'); ?>

                            </p>
                            <p class="text-xs text-gray-500 truncate max-w-[150px] lg:max-w-none">
                                <?php echo e(Auth::user()->companyRoles()->where('company_id', Auth::user()->company_id)->first()->role->name ?? 'No Role'); ?>

                            </p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 hidden sm:block"></i>
                    </button>
                    <!-- Profile Dropdown Menu -->
                    <div x-show="open" x-transition @click.away="open = false"
                        class="absolute right-0 w-48 sm:w-52 mt-2 backdrop-blur-sm rounded-xl shadow-lg border bg-white border-gray-100 z-50">
                        <!-- Mobile Profile Info (Shown only on small screens) -->
                        <div class="sm:hidden p-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900"><?php echo e(auth()->user()->name ?? 'Admin User'); ?></p>
                            <p class="text-xs text-gray-500">
                                <?php echo e(Auth::user()->companyRoles()->where('company_id', Auth::user()->company_id)->first()->role->name ?? 'No Role'); ?>

                            </p>
                        </div>
                        <div class="p-2">
                            <a href="/user/profile/profile"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A] rounded-lg transition-all duration-200">
                                <i class="fas fa-user w-4"></i>
                                <span>Profile</span>
                            </a>
                            <a href="/user/change-password/change-password"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-[#C3D4EC]/20 hover:text-[#1E3A8A] rounded-lg transition-all duration-200">
                                <i class="fas fa-lock w-4"></i>
                                <span>Ubah Password</span>
                            </a>
                            
                            <hr class="my-1 border-gray-100">
                            <a href="/logout"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                                <i class="fas fa-sign-out-alt w-4"></i>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/layout/navbar.blade.php ENDPATH**/ ?>