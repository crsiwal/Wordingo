<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <!-- Header Section with Animated Background -->
    <div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
        <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="text-white">
                <h1 class="text-5xl font-bold leading-tight mb-2">Users</h1>
                <p class="text-indigo-100 text-xl">Manage system users and permissions</p>
                <div class="flex items-center mt-4 text-indigo-100">
                    <span class="flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        <span><?= count($users) ?> Users</span>
                    </span>
                </div>
            </div>
            <a href="<?= base_url('admin/users/create') ?>" class="group relative px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <span class="w-7 h-7 flex items-center justify-center bg-indigo-100 rounded-full mr-2 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </span>
                    New User
                </span>
                <span class="absolute inset-0 w-0 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute inset-0 w-full h-full opacity-0 group-hover:opacity-20 bg-grid-white/20 bg-grid-8 transition-opacity duration-300"></span>
            </a>
        </div>

        <!-- Animated bubbles background effect -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="absolute rounded-full bg-white/30"
                     style="<?= 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;'?>"></div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="mb-8 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="user-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5" placeholder="Search users..." onkeyup="filterUsers()">
            </div>
            <div class="flex gap-2">
                <select id="role-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5" onchange="filterUsers()">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="grid grid-cols-1 gap-6">
        <?php foreach ($users as $user): ?>
            <div class="user-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div class="flex items-start gap-4">
                            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <h3 class="user-name text-xl font-semibold text-gray-900 mb-1"><?= esc($user['name']) ?></h3>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 text-sm text-gray-500 mb-2">
                                    <span class="flex items-center">
                                        <i class="fas fa-at text-indigo-400 mr-1"></i>
                                        <?= esc($user['username'] ?? '') ?>
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-envelope text-purple-400 mr-1"></i>
                                        <?= esc($user['email']) ?>
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar text-blue-400 mr-1"></i>
                                        <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                    </span>
                                </div>
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="user-role px-3 py-1 rounded-full text-xs <?= $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                        <?= number_format($user['post_count'] ?? 0) ?> Posts
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" 
                               class="px-3 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors inline-flex items-center">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <?php if ($user['id'] !== session()->get('user_id')): ?>
                                <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" 
                                   class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors inline-flex items-center"
                                   onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash mr-1"></i>
                                    Delete
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Gradient bar at bottom -->
                <div class="h-1 bg-gradient-to-r <?= $user['role'] === 'admin' ? 'from-purple-500 to-indigo-500' : 'from-blue-500 to-cyan-500' ?>"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State (shown when no users match filter) -->
    <div id="empty-state" class="hidden text-center py-12 bg-white rounded-xl shadow-sm mt-6">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-users text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-2">No users found</h3>
        <p class="text-gray-500 mb-6">Try adjusting your search or filter to find what you're looking for.</p>
        <button onclick="resetSearch()" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
            <i class="fas fa-redo mr-2"></i> Reset Search
        </button>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager)): ?>
        <div class="mt-8 flex justify-center">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>

    <style>
        .bg-grid-white\/20 {
            mask-image: linear-gradient(to bottom, transparent, black);
        }

        .bg-grid-8 {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>

    <script>
        function filterUsers() {
            const searchTerm = document.getElementById('user-search').value.toLowerCase();
            const roleFilter = document.getElementById('role-filter').value.toLowerCase();
            const userCards = document.querySelectorAll('.user-card');
            let visibleCount = 0;

            userCards.forEach(card => {
                const name = card.querySelector('.user-name').textContent.toLowerCase();
                const role = card.querySelector('.user-role').textContent.toLowerCase();

                const matchesSearch = name.includes(searchTerm);
                const matchesRole = roleFilter === '' || role.includes(roleFilter);

                if (matchesSearch && matchesRole) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide empty state
            const emptyState = document.getElementById('empty-state');
            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        function resetSearch() {
            document.getElementById('user-search').value = '';
            document.getElementById('role-filter').value = '';
            filterUsers();
        }
    </script>
<?= $this->endSection() ?> 