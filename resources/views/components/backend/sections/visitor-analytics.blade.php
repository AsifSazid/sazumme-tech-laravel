<div class="p-4 bg-white shadow rounded-xl">
    <h2 class="text-xl font-bold mb-6 text-center">Visitor Analytics Dashboard</h2>

    {{-- Grid Layout: 2 columns --}}
    <div class="grid md:grid-cols-2 gap-8">

        {{-- Bar Chart Column --}}
        <div class="space-y-4">
            <div>
                <label for="barRange" class="block text-sm font-medium mb-1">Visitor Counter:</label>
                <select id="barRange" class="w-full border rounded px-2 py-1">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <div class="bg-gray-50 p-2 rounded shadow-inner">
                <canvas id="barChart" height="150"></canvas>
            </div>
        </div>

        {{-- Pie Chart Column --}}
        <div class="space-y-4">
            <div>
                <label for="pieRange" class="block text-sm font-medium mb-1">Visit From:</label>
                <select id="pieRange" class="w-full border rounded px-2 py-1">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <div class="bg-gray-50 p-2 rounded shadow-inner">
                <canvas id="pieChart" height="150"></canvas>
            </div>
        </div>

    </div>
</div>


{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const barCtx = document.getElementById('barChart').getContext('2d');
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    let barChart, pieChart;

    async function fetchChartData(endpoint) {
        const res = await fetch(endpoint);
        return await res.json();
    }

    function renderBarChart(data) {
        const labels = data.map(item => item.label);
        const counts = data.map(item => item.count);

        if (barChart) barChart.destroy();

        barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Visitors',
                    data: counts,
                    backgroundColor: '#60a5fa',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: undefined, // auto calculate
                            callback: function(value) {
                                return Math.round(value); // force integer display
                            }
                        },
                        afterDataLimits: (scale) => {
                            let max = scale.max;
                            let step;

                            if (max <= 50) {
                                step = 5;
                            } else if (max <= 500) {
                                step = 50;
                            } else if (max <= 5000) {
                                step = 500;
                            } else {
                                step = 5000;
                            }

                            // next multiple of step over max value
                            const nextMax = Math.ceil(max / step) * step;

                            scale.max = nextMax;
                            scale.min = 0;
                            scale.ticks.stepSize = step;
                        }
                    }
                }
            }
        });
    }

    function renderPieChart(data) {
        const labels = data.map(item => item.visit_from);
        const counts = data.map(item => item.count);

        if (pieChart) pieChart.destroy();

        pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data: counts,
                    backgroundColor: [
                        '#60a5fa', '#34d399', '#facc15', '#f472b6', '#a78bfa', '#fb923c'
                    ]
                }]
            },
            options: {
                responsive: true,
            }
        });
    }

    async function updateBarChart(range) {
        const data = await fetchChartData(`/api/visitors/summary?type=${range}`);
        renderBarChart(data);
    }

    async function updatePieChart(range) {
        const data = await fetchChartData(`/api/visitors/source-chart?type=${range}`);
        renderPieChart(data);
    }

    // Initial Load
    document.addEventListener('DOMContentLoaded', () => {
        const barRange = document.getElementById('barRange');
        const pieRange = document.getElementById('pieRange');

        updateBarChart(barRange.value);
        updatePieChart(pieRange.value);

        barRange.addEventListener('change', () => updateBarChart(barRange.value));
        pieRange.addEventListener('change', () => updatePieChart(pieRange.value));
    });
</script>
