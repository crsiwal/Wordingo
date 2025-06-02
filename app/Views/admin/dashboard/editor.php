<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="dashboard-container">
    <div class="mb-10 animate-fade-in">
        <h1 class="text-5xl font-extrabold leading-tight tracking-tight text-gray-900 bg-gradient-to-r from-primary-600 to-blue-600 bg-clip-text text-transparent">Dashboard</h1>
        <p class="text-gray-500 text-lg mt-2">Welcome back, <span class="font-semibold text-primary-600"><?= session()->get('user_name') ?></span>! 👋</p>
    </div>

    <!-- Quick Actions -->
    <div class="mb-12">
        <div class="flex flex-wrap gap-4">
            <a href="<?= base_url('admin/posts/create') ?>" class="group flex-1 min-w-[200px] flex items-center gap-3 px-6 py-4 rounded-2xl font-semibold bg-gradient-to-r from-primary-600 to-blue-600 text-white shadow-lg hover:shadow-xl hover:from-primary-700 hover:to-blue-700 transition-all duration-300 text-lg transform hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300 text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span>New Post</span>
                    <span class="text-sm text-white/80 font-normal">Create a new blog post</span>
                </div>
            </a>
            <a href="<?= base_url('admin/profile') ?>" class="group flex-1 min-w-[200px] flex items-center gap-3 px-6 py-4 rounded-2xl font-semibold bg-gradient-to-r from-gray-700 to-gray-900 text-white shadow-lg hover:shadow-xl hover:from-gray-800 hover:to-black transition-all duration-300 text-lg transform hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-user group-hover:scale-110 transition-transform duration-300 text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span>Edit Profile</span>
                    <span class="text-sm text-white/80 font-normal">Update your profile</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Editor Stats -->
    <?php
    $stats = [
        ['label' => 'Total Posts', 'value' => $totalPosts, 'icon' => 'fa-file-alt', 'color' => 'bg-primary-100 text-primary-600', 'gradient' => 'from-primary-500 to-primary-600'],
        ['label' => 'Published Posts', 'value' => $publishedPosts, 'icon' => 'fa-check-circle', 'color' => 'bg-green-100 text-green-600', 'gradient' => 'from-green-500 to-green-600'],
        ['label' => 'Total Views', 'value' => $totalViews, 'icon' => 'fa-eye', 'color' => 'bg-blue-100 text-blue-600', 'gradient' => 'from-blue-500 to-blue-600'],
    ];
    ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
        <?php foreach ($stats as $index => $stat): ?>
            <div class="bg-white rounded-2xl shadow-lg p-7 flex items-center gap-4 hover:shadow-xl transition-all duration-300 border border-gray-100 transform hover:-translate-y-1 animate-fade-in" style="animation-delay: <?= $index * 100 ?>ms">
                <div class="p-4 rounded-xl bg-gradient-to-r <?= $stat['gradient'] ?> flex items-center justify-center text-3xl shadow-sm text-white">
                    <i class="fas <?= $stat['icon'] ?>"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900 leading-tight">
                        <?= number_format($stat['value']) ?>
                    </div>
                    <div class="text-gray-500 text-base mt-1 font-medium tracking-wide"><?= $stat['label'] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <hr class="my-10 border-t-2 border-gray-100">

    <!-- Analytics and Insights Section -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Analytics & Insights</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Views Over Time Chart -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Post Views Over Time</h3>
                        <p class="text-gray-500 text-sm mt-1">Last 30 days</p>
                    </div>
                </div>
                <div id="viewsChart" class="h-80" data-chart="echarts"></div>
            </div>

            <!-- Post Published Over Time Chart -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Post Published Over Time</h3>
                        <p class="text-gray-500 text-sm mt-1">Last 30 days</p>
                    </div>
                </div>
                <div id="postPublishedChart" class="h-80" data-chart="echarts"></div>
            </div>

            <!-- Category Posts Count Chart -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Category Posts Count</h3>
                        <p class="text-gray-500 text-sm mt-1">Posts by category</p>
                    </div>
                </div>
                <div id="categoryPostsCountChart" class="h-80" data-chart="echarts"></div>
            </div>

            <!-- Category Posts View Count Chart -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Category Posts View Count</h3>
                        <p class="text-gray-500 text-sm mt-1">Views by category</p>
                    </div>
                </div>
                <div id="categoryPostsViewCountChart" class="h-80" data-chart="echarts"></div>
            </div>
        </div>
    </div>

    <!-- Recent Content Section -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Content</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Posts -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Posts</h3>
                        <p class="text-gray-500 text-sm mt-1">Latest blog posts</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="<?= base_url('admin/posts/create') ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i> New Post
                        </a>
                        <a href="<?= base_url('admin/posts') ?>" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors duration-200 flex items-center gap-2 group">
                            View All <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                <div class="space-y-4">
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-primary-500 to-blue-500 flex items-center justify-center text-white text-lg font-bold shadow-md">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 truncate max-w-[300px]">
                                            <a target="_blank" href="<?= postUrl($post); ?>" class="hover:text-primary-600 transition-colors">
                                                <?= esc($post['title']) ?>
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <span>
                                                <?= date('M d, Y', strtotime($post['published_at'])) ?>,
                                            </span>
                                            <span>
                                                <?= $post['views'] ?> views
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>" class="p-2 text-gray-500 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Popular Posts -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Popular Posts</h3>
                        <p class="text-gray-500 text-sm mt-1">Most viewed content</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <?php foreach ($popularPosts as $index => $post): ?>
                        <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-4 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 animate-fade-in group" style="animation-delay: <?= $index * 100 ?>ms">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary-500 to-blue-500 flex items-center justify-center text-white text-xl font-bold shadow-md">
                                <?= $index + 1 ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 truncate group-hover:text-primary-600 transition-colors cursor-pointer" title="<?= esc($post['title']) ?>">
                                    <?= esc($post['title']) ?>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-clock"></i>
                                        <?= time_elapsed_string($post['published_at']) ?>
                                    </span>
                                    <span>•</span>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-eye"></i>
                                        <span><?= number_format($post['views']) ?> views</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories and Tags Section -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Categories & Tags</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Categories -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Categories</h3>
                        <p class="text-gray-500 text-sm mt-1">Post distribution</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <?php foreach ($categories as $index => $category): ?>
                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 animate-fade-in group" style="animation-delay: <?= $index * 100 ?>ms">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center text-white text-lg font-bold shadow-md">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <div>
                                    <a href="<?= base_url('admin/posts?c=' . urlencode($category['slug'])) ?>" class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors">
                                        <?= esc($category['name']) ?>
                                    </a>
                                    <div class="text-sm text-gray-500">
                                        <?= number_format($category['posts_count']) ?> posts
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                <?= number_format($category['percentage'], 1) ?>%
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Trending Tags -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Trending Tags</h3>
                        <p class="text-gray-500 text-sm mt-1">Most used tags</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($trendingTags as $index => $tag): ?>
                        <a href="<?= base_url('admin/tags/' . $tag['slug']) ?>"
                            class="px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-700 hover:bg-purple-200 transition-colors duration-200 flex items-center gap-2 animate-fade-in"
                            style="animation-delay: <?= $index * 100 ?>ms">
                            <i class="fas fa-tag"></i>
                            <?= esc($tag['name']) ?>
                            <span class="text-purple-500">(<?= number_format($tag['count']) ?>)</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        try {
            // Views Chart
            const $viewsChartElement = $('#viewsChart');
            if ($viewsChartElement.length) {
                const viewsChart = echarts.init($viewsChartElement[0]);
                const viewsData = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: '#6a7985'
                            }
                        }
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: <?= json_encode(array_column($dailyPostsViewCount, 'date')) ?>,
                        axisLine: {
                            lineStyle: {
                                color: '#E5E7EB'
                            }
                        },
                        axisLabel: {
                            color: '#6B7280',
                            formatter: function(value) {
                                return moment(value).format('MMM D');
                            }
                        }
                    },
                    yAxis: {
                        type: 'value',
                        axisLine: {
                            show: false
                        },
                        axisLabel: {
                            color: '#6B7280',
                            formatter: function(value) {
                                return numeral(value).format('0a');
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: '#E5E7EB'
                            }
                        }
                    },
                    series: [{
                        name: 'Views',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 8,
                        data: <?= json_encode(array_column($dailyPostsViewCount, 'views')) ?>,
                        itemStyle: {
                            color: '#4F46E5'
                        },
                        areaStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                offset: 0,
                                color: 'rgba(79, 70, 229, 0.2)'
                            }, {
                                offset: 1,
                                color: 'rgba(79, 70, 229, 0)'
                            }])
                        }
                    }]
                };
                viewsChart.setOption(viewsData);
            }

            // Posts Published Chart
            const $postPublishedChartElement = $('#postPublishedChart');
            if ($postPublishedChartElement.length) {
                const postPublishedChart = echarts.init($postPublishedChartElement[0]);
                const postPublishedData = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: '#6a7985'
                            }
                        }
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: <?= json_encode(array_column($dailyPostsPublishedCount, 'date')) ?>,
                        axisLine: {
                            lineStyle: {
                                color: '#E5E7EB'
                            }
                        },
                        axisLabel: {
                            color: '#6B7280',
                            formatter: function(value) {
                                return moment(value).format('MMM D');
                            }
                        }
                    },
                    yAxis: {
                        type: 'value',
                        axisLine: {
                            show: false
                        },
                        axisLabel: {
                            color: '#6B7280'
                        },
                        splitLine: {
                            lineStyle: {
                                color: '#E5E7EB'
                            }
                        }
                    },
                    series: [{
                        name: 'Posts',
                        type: 'bar',
                        data: <?= json_encode(array_column($dailyPostsPublishedCount, 'posts')) ?>,
                        itemStyle: {
                            color: '#10B981'
                        }
                    }]
                };
                postPublishedChart.setOption(postPublishedData);
            }

            // Category Posts Count Chart
            const $categoryPostsCountChartElement = $('#categoryPostsCountChart');
            if ($categoryPostsCountChartElement.length) {
                const categoryPostsCountChart = echarts.init($categoryPostsCountChartElement[0]);
                const categoryPostsCountData = {
                    tooltip: {
                        trigger: 'item',
                        formatter: '{b}: {c} posts'
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        top: 'center',
                        textStyle: {
                            color: '#6B7280',
                            fontFamily: 'Geist Mono'
                        }
                    },
                    series: [{
                        name: 'Posts by Category',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        center: ['60%', '50%'],
                        avoidLabelOverlap: false,
                        itemStyle: {
                            borderRadius: 10,
                            borderColor: '#fff',
                            borderWidth: 2
                        },
                        label: {
                            show: false
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: '18',
                                fontWeight: 'bold'
                            }
                        },
                        data: <?= json_encode(array_map(function ($name, $count) {
                                    return ['name' => $name, 'value' => $count];
                                }, array_keys($categoryPostsCount), array_values($categoryPostsCount))) ?>
                    }]
                };
                categoryPostsCountChart.setOption(categoryPostsCountData);
            }

            // Category Posts View Count Chart
            const $categoryPostsViewCountChartElement = $('#categoryPostsViewCountChart');
            if ($categoryPostsViewCountChartElement.length) {
                const categoryPostsViewCountChart = echarts.init($categoryPostsViewCountChartElement[0]);
                const categoryPostsViewCountData = {
                    tooltip: {
                        trigger: 'item',
                        formatter: '{b}: {c} views'
                    },
                    legend: {
                        orient: 'vertical',
                        right: 'right',
                        top: 'center',
                        textStyle: {
                            color: '#6B7280',
                            fontFamily: 'Geist Mono'
                        }
                    },
                    series: [{
                        name: 'Views by Category',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        center: ['40%', '50%'],
                        avoidLabelOverlap: false,
                        itemStyle: {
                            borderRadius: 10,
                            borderColor: '#fff',
                            borderWidth: 2
                        },
                        label: {
                            show: false
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: '18',
                                fontWeight: 'bold'
                            }
                        },
                        data: <?= json_encode(array_map(function ($name, $count) {
                                    return ['name' => $name, 'value' => $count];
                                }, array_keys($categoryPostsViewCount), array_values($categoryPostsViewCount))) ?>
                    }]
                };
                categoryPostsViewCountChart.setOption(categoryPostsViewCountData);
            }

            // Handle window resize
            $(window).on('resize', function() {
                $('[data-chart="echarts"]').each(function() {
                    const chart = echarts.getInstanceByDom(this);
                    if (chart) {
                        chart.resize();
                    }
                });
            });

        } catch (error) {
            console.error('Error in chart initialization:', error);
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    /* Chart tooltip styles */
    .chart-tooltip {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Dashboard specific styles */
    .dashboard-container {
        min-height: calc(100vh - 200px);
        overflow-x: hidden;
    }

    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
    }
</style>
<?= $this->endSection() ?>