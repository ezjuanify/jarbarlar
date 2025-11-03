<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Function to display the Boost Report page
function wp_speedy_boost_report_page() {
    ?>
    <div class="wrap">
        <h1>Your Dashboard</h1>

        <!-- Main Row: Two Columns -->
        <div class="main-row">
            <!-- First Column: Service Results (Top) and Quick Actions (Bottom) -->
            <div class="first-column">
                <!-- Service Results Section -->
                <div class="service-results card-effect">
                    <h2>Service Results</h2>
                    <div class="results-wrapper">
                        <div class="result-box">
                            <span class="icon">&#9673;</span>
                            <p class="value">38%</p>
                            <p class="label">Cache hit ratio</p>
                        </div>
                        <div class="result-box">
                            <span class="icon">&#128230;</span>
                            <p class="value">1000 KB</p>
                            <p class="label">Cache size</p>
                        </div>
                        <div class="result-box">
                            <span class="icon">&#128339;</span>
                            <p class="value">3 days ago</p>
                            <p class="label">Last Purge</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Chart Section -->
                <div class="chart-section card-effect">
                    <h2>Quick Actions</h2>
                    <p class="chart-label">Cache hit Ratio</p>
                    <div class="chart-container">
                        <canvas id="quickActionsChart"></canvas>
                    </div>
                    <button class="see-more">See More</button>
                </div>
            </div>

            <!-- Second Column: Optimization Status -->
            <div class="status-section card-effect">
                <h2>Optimization Status</h2>
                <p class="total-pages-label">Total pages found: <span class="total-pages">27</span></p>
                <div class="chart-container large-chart-container">
                    <canvas id="optimizationChart"></canvas>
                </div>
                <div class="legend">
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #00bcd4;"></span> Optimization Complete: 7
                    </div>
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #8bc34a;"></span> Scheduled for Optimization: 3
                    </div>
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #ff9800;"></span> Not Eligible for Optimization: 12
                    </div>
                    <div class="legend-item">
                        <span class="color-box" style="background-color: #f44336;"></span> Optimization Failed: 5
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Row: Two Columns -->
        <div class="additional-row">
            <!-- First Column: Graph -->
            <div class="quick-actions-column card-effect">
                <div class="chart-section">
                    <h2>Quick Actions</h2>
                    <div class="chart-container">
                        <canvas id="additionalGraphChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Second Column: Two Parts -->
            <div class="settings-column">
                <!-- Top Part: Quick Actions Settings -->
                <div class="settings-section card-effect">
                    <h2>Quick Actions</h2>
                    <div class="toggle-settings">
                        <label>Cache warmup</label>
                        <input type="checkbox">
                    </div>
                    <div class="toggle-settings">
                        <label>Test mode</label>
                        <input type="checkbox">
                    </div>
                    <div class="toggle-settings">
                        <label>Optimization mode</label>
                        <span class="mode">Standard</span>
                    </div>
                    <button class="purge-cache">Purge Cache</button>
                </div>

                <!-- Bottom Part: Free Subscription -->
                <div class="subscription-section card-effect">
                    <h2>Free Subscription</h2>
                    <p class="subscription-info">ausdigital.agency</p>
                    <div class="progress-info">
                        <p>Page Views: 30 / 5000</p>
                        <progress value="30" max="5000"></progress>
                    </div>
                    <div class="progress-info">
                        <p>CDN Bandwidth: 20.19 / 1GB</p>
                        <progress value="20.19" max="1000"></progress>
                    </div>
                    <div class="reset-info">
                        <p>Next Reset: <span>Sept 9, 2024</span></p>
                    </div>
                    <button class="subscription-btn">Subscription</button>
                </div>
            </div>
        </div>

        <!-- Chart.js Integration -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Quick Actions Chart
                const ctxQuickActions = document.getElementById('quickActionsChart').getContext('2d');
                new Chart(ctxQuickActions, {
                    type: 'bar',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [
                            { label: 'Data One', data: [40, 80, 90, 60, 70, 50, 100], backgroundColor: '#00bcd4' },
                            { label: 'Data Two', data: [30, 70, 50, 40, 90, 80, 60], backgroundColor: '#ff9800' }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                // Optimization Status Chart
                const ctxOptimization = document.getElementById('optimizationChart').getContext('2d');
                new Chart(ctxOptimization, {
                    type: 'doughnut',
                    data: {
                        labels: ['Optimization Complete', 'Scheduled for Optimization', 'Not Eligible for Optimization', 'Optimization Failed'],
                        datasets: [{
                            data: [7, 3, 12, 5],
                            backgroundColor: ['#00bcd4', '#8bc34a', '#ff9800', '#f44336']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                // Additional Graph Chart
                const ctxAdditionalGraph = document.getElementById('additionalGraphChart').getContext('2d');
                new Chart(ctxAdditionalGraph, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'Dataset 2',
                            data: [50, 60, 70, 80, 90, 100, 110],
                            borderColor: '#f57c00',
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });
        </script>

        <!-- CSS Styles -->
        <style>
            .wrap {
                padding: 20px;
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                border-radius: 8px;
            }
            h1 {
                font-size: 24px;
                margin-bottom: 20px;
                color: #d32f2f;
            }
            .main-row, .additional-row {
                display: flex;
                gap: 20px;
                margin-top: 20px;
            }
            .first-column, .status-section, .quick-actions-column {
                flex: 1;
            }
            .settings-column {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .service-results, .chart-section, .status-section, .settings-section, .subscription-section {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            .results-wrapper {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .result-box {
                text-align: center;
                width: 100px;
            }
            .icon {
                font-size: 30px;
                color: #333;
                margin-bottom: 10px;
            }
            .value {
                font-size: 20px;
                font-weight: bold;
            }
            .label {
                color: #555;
            }
            .chart-label {
                font-size: 16px;
                margin-bottom: 10px;
                color: #555;
            }
            .chart-container {
                position: relative;
                height: 300px;
            }
            .large-chart-container {
                height: 450px;
            }
            .see-more, .purge-cache, .subscription-btn {
                background: #d32f2f;
                color: #fff;
                border: none;
                padding: 8px 16px;
                cursor: pointer;
                border-radius: 4px;
                margin-top: 10px;
            }
            .legend {
                margin-top: 10px;
            }
            .color-box {
                display: inline-block;
                width: 12px;
                height: 12px;
                margin-right: 5px;
            }
        </style>
    <?php
}
