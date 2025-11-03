<?php
function wp_speedy_visitor_analytics_page() {
    ?>
    <div class="wrap">
        <h1>Visitor Analytics</h1>
        <div class="visitor-analytics-container">
            <!-- First Column: Four Statistic Boxes in a 2x2 Grid -->
            <div class="analytics-column">
                <div class="analytics-box-container">
                    <div class="analytics-box">
                        <h2>Sessions</h2>
                        <p class="main-value" id="sessions">Loading...</p>
                        <p class="change-value" id="sessions-change">Loading...</p>
                        <p class="comparison-text">vs Previous 30 Days</p>
                    </div>
                    <div class="analytics-box">
                        <h2>Page Views</h2>
                        <p class="main-value" id="page-views">Loading...</p>
                        <p class="change-value" id="page-views-change">Loading...</p>
                        <p class="comparison-text">vs Previous 30 Days</p>
                    </div>
                    <div class="analytics-box">
                        <h2>Avg. Duration</h2>
                        <p class="main-value" id="avg-duration">Loading...</p>
                        <p class="change-value" id="avg-duration-change">Loading...</p>
                        <p class="comparison-text">vs Previous 30 Days</p>
                    </div>
                    <div class="analytics-box">
                        <h2>Bounce Rate</h2>
                        <p class="main-value" id="bounce-rate">Loading...</p>
                        <p class="change-value" id="bounce-rate-change">Loading...</p>
                        <p class="comparison-text">vs Previous 30 Days</p>
                    </div>
                </div>
            </div>

            <!-- Second Column: New vs Returning Visitors Chart -->
            <div class="analytics-chart-column">
                <h2>New vs Returning Visitors</h2>
                <canvas id="newReturningChart" width="280" height="280"></canvas>
            </div>

            <!-- Third Column: Device Breakdown Chart -->
            <div class="analytics-chart-column">
                <h2>Device Breakdown</h2>
                <canvas id="deviceBreakdownChart" width="280" height="280"></canvas>
            </div>
        </div>

        <!-- User By Country Section -->
        <div class="user-country-section">
            <h2>User By Country</h2>
            <div class="country-data-container">
                <div class="world-map">
                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/world_map.png'; ?>" alt="World Map" />
                </div>
                <div class="top-countries">
                    <h3>Top Countries <a href="#" class="see-all-link">See All</a></h3>
                    <ul class="country-list" id="country-list">
                        <!-- List items will be dynamically populated -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- New Section: Top 10 Referrals and Top Page/Post -->
        <div class="additional-analytics-section">
            <div class="referrals-section">
                <h2>Top 10 Referrals</h2>
                <ul class="referral-list">
                    <li>
                        <span class="referral-icon"><img src="<?php echo plugin_dir_url(__FILE__) . 'assets/facebook.webp'; ?>" alt="Facebook"></span>
                        <span class="referral-name">Facebook</span>
                        <span class="referral-count">4963</span>
                    </li>
                    <!-- Add more referral items similarly -->
                </ul>
            </div>
            <div class="top-page-post-section">
                <h2>Top Page/Post</h2>
                <table class="page-post-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th>Post</th>
                            <th>Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>www.facebook.com</td>
                            <td>Lorem Ipsum is simply dum...</td>
                            <td>9,636</td>
                            <td><a href="#" class="details-link">Details</a></td>
                        </tr>
                        <!-- Add more rows similarly -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Include Chart.js from CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fetch real-time data using WordPress AJAX
                fetch(ajaxurl + '?action=fetch_analytics_data')
                    .then(response => response.json())
                    .then(data => {
                        // Populate the data dynamically
                        document.getElementById('sessions').textContent = data.sessions;
                        document.getElementById('sessions-change').textContent = data.sessionsChange;
                        document.getElementById('page-views').textContent = data.pageViews;
                        document.getElementById('page-views-change').textContent = data.pageViewsChange;
                        document.getElementById('avg-duration').textContent = data.avgDuration;
                        document.getElementById('avg-duration-change').textContent = data.avgDurationChange;
                        document.getElementById('bounce-rate').textContent = data.bounceRate;
                        document.getElementById('bounce-rate-change').textContent = data.bounceRateChange;

                        // Update the charts
                        const ctx1 = document.getElementById('newReturningChart').getContext('2d');
                        new Chart(ctx1, {
                            type: 'doughnut',
                            data: {
                                labels: ['New User', 'Returning User'],
                                datasets: [{
                                    data: [data.newUsers, data.returningUsers],
                                    backgroundColor: ['#00bcd4', '#f44336']
                                }]
                            }
                        });

                        const ctx2 = document.getElementById('deviceBreakdownChart').getContext('2d');
                        new Chart(ctx2, {
                            type: 'doughnut',
                            data: {
                                labels: ['Desktop', 'Tablet', 'Mobile'],
                                datasets: [{
                                    data: [data.desktopUsers, data.tabletUsers, data.mobileUsers],
                                    backgroundColor: ['#f44336', '#ff9800', '#8bc34a']
                                }]
                            }
                        });

                        // Populate top countries
                        const countryList = document.getElementById('country-list');
                        data.topCountries.forEach(country => {
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `
                                <span class="country-flag"><img src="${country.flag}" alt="${country.name}"></span>
                                <span class="country-name">${country.name}</span>
                                <span class="country-users">${country.users}</span>
                            `;
                            countryList.appendChild(listItem);
                        });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });
        </script>

        <style>
            .visitor-analytics-container {
                display: flex;
                justify-content: space-between;
                gap: 20px;
            }
            .analytics-column {
                flex: 1;
            }
            .analytics-box-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            .analytics-box {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .main-value {
                font-size: 24px;
                font-weight: bold;
                margin: 10px 0;
            }
            .change-value {
                font-size: 14px;
                color: #4caf50;
                margin-bottom: 5px;
            }
            .comparison-text {
                font-size: 12px;
                color: #777;
            }
            .analytics-chart-column {
                flex: 1;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            canvas {
                max-width: 280px;
                margin: 0 auto;
            }
            .user-country-section {
                margin-top: 40px;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
            }
            .country-data-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }
            .world-map {
                flex: 2;
                padding: 10px;
                text-align: center;
            }
            .world-map img {
                width: 100%;
                height: auto;
                border-radius: 8px;
            }
            .top-countries {
                flex: 1;
                min-width: 250px;
            }
            .top-countries h3 {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .see-all-link {
                font-size: 12px;
                color: #0073aa;
                text-decoration: none;
            }
            .country-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .country-list li {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border-bottom: 1px solid #eee;
            }
            .country-flag img {
                width: 20px;
                height: 20px;
                border-radius: 50%;
            }
            .country-name {
                flex: 1;
                margin-left: 10px;
                font-weight: 500;
            }
            .country-users {
                font-weight: bold;
            }
            .additional-analytics-section {
                display: flex;
                margin-top: 40px;
                gap: 20px;
            }
            .referrals-section, .top-page-post-section {
                flex: 1;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
            }
            .referral-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .referral-list li {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border-bottom: 1px solid #eee;
            }
            .referral-icon img {
                width: 20px;
                height: 20px;
                border-radius: 50%;
            }
            .referral-name {
                flex: 1;
                margin-left: 10px;
                font-weight: 500;
            }
            .referral-count {
                font-weight: bold;
            }
            .page-post-table {
                width: 100%;
                border-collapse: collapse;
            }
            .page-post-table th, .page-post-table td {
                padding: 8px;
                border-bottom: 1px solid #eee;
                text-align: left;
            }
            .details-link {
                color: #f44336;
                text-decoration: none;
            }
        </style>
    </div>
    <?php
}

// Register the AJAX action
add_action('wp_ajax_fetch_analytics_data', 'fetch_analytics_data');
add_action('wp_ajax_nopriv_fetch_analytics_data', 'fetch_analytics_data');

function fetch_analytics_data() {
    // Example: Simulate data fetching from an API or your server
    $data = [
        'sessions' => 6132,
        'sessionsChange' => '+150%',
        'pageViews' => 11236,
        'pageViewsChange' => '-202',
        'avgDuration' => '46s',
        'avgDurationChange' => '+22%',
        'bounceRate' => '46s',
        'bounceRateChange' => '+30',
        'newUsers' => 2000,
        'returningUsers' => 600,
        'desktopUsers' => 2000,
        'tabletUsers' => 1000,
        'mobileUsers' => 1500,
        'topCountries' => [
            ['flag' => plugin_dir_url(__FILE__) . 'assets/usa.webp', 'name' => 'United States', 'users' => 32900],
            ['flag' => plugin_dir_url(__FILE__) . 'assets/france.webp', 'name' => 'France', 'users' => 30456],
            ['flag' => plugin_dir_url(__FILE__) . 'assets/india.webp', 'name' => 'India', 'users' => 29703],
            ['flag' => plugin_dir_url(__FILE__) . 'assets/spain.webp', 'name' => 'Spain', 'users' => 27533],
            ['flag' => plugin_dir_url(__FILE__) . 'assets/bangladesh.webp', 'name' => 'Bangladesh', 'users' => 27523],
            ['flag' => plugin_dir_url(__FILE__) . 'assets/brazil.webp', 'name' => 'Brazil', 'users' => 23289]
        ]
    ];

    wp_send_json($data);
}
