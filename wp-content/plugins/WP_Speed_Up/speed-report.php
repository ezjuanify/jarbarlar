<?php
// Check if 'ABSPATH' is defined to prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function wordpress_speedy_speed_report_page() {
    ?>
    <div class="container">
        <h1>Congrats! You can see the updated speed score below -</h1>
        <div class="tabs">
            <div class="tab active" data-tab="desktop" onclick="switchTab('desktop')">Desktop</div>
            <div class="tab" data-tab="mobile" onclick="switchTab('mobile')">Mobile</div>
        </div>

        <!-- Desktop Content -->
        <div class="content active" data-content="desktop" id="desktopContent">
            <!-- Boosted and Old Data for Desktop will be dynamically loaded here -->
        </div>

        <!-- Mobile Content -->
        <div class="content" data-content="mobile" id="mobileContent">
            <!-- Boosted and Old Data for Mobile will be dynamically loaded here -->
        </div>
    </div>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            border: 1px solid #ddd;
            cursor: pointer;
            margin: 0 5px;
            border-radius: 5px;
        }

        .tab.active {
            background-color: #f5f5f5;
            border-bottom: 2px solid #d32f2f;
            font-weight: bold;
        }

        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        .speed-report {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .speed-box {
            width: 48%;
            border: 2px solid;
            border-radius: 10px;
            padding: 15px;
        }

        .speed-box.boosted {
            border-color: #28a745;
        }

        .speed-box.old {
            border-color: #dc3545;
        }

        .speed-box h3 {
            color: #d32f2f;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .url {
            font-weight: bold;
            color: #d32f2f;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .url:hover {
            text-decoration: underline;
        }

        .details {
            margin-top: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #f8d7da;
            color: #721c24;
            padding: 8px;
            text-align: center;
            border: 1px solid #f5f5f5;
        }

        .table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table .header-row {
            background-color: #f8d7da;
            font-weight: bold;
        }
    </style>

    <script>
        // Function to switch tabs (Desktop/Mobile)
        function switchTab(tabName) {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.content');

            tabs.forEach(tab => tab.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));

            document.querySelector(`.tab[data-tab="${tabName}"]`).classList.add('active');
            document.querySelector(`.content[data-content="${tabName}"]`).classList.add('active');
        }

        // Fetch and update speed data dynamically
        async function fetchSpeedData() {
            try {
                const apiUrl = 'https://app.wordpressspeedy.com/api/wordpress/get_speed_data';
                const token = '<?= get_option('connection_token') ?>';
                const hostname = window.location.hostname;

                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token, hostname }),
                });

                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                const result = await response.json();
                if (result.status === "success" && Array.isArray(result.message)) {
                    const homepageBoostStatus = result.message.find(item => item.page_type === "homepage")?.speed_boost || 0;

                    const desktopBoosted = result.message.map(item => ({
                        url: item.url,
                        performance: homepageBoostStatus === 0 ? null : item.desktop_score,
                        fcp: homepageBoostStatus === 0 ? null : item.desktopFCP,
                        lcp: homepageBoostStatus === 0 ? null : item.desktopLCP,
                        cls: homepageBoostStatus === 0 ? null : item.desktopCLS,
                        tbt: homepageBoostStatus === 0 ? null : item.desktopTBT,
                        si: homepageBoostStatus === 0 ? null : item.desktopSI,
                    }));

                    const desktopOld = result.message.map(item => ({
                        url: item.url,
                        performance: item.old_desktop_score,
                        fcp: item.old_desktopFCP,
                        lcp: item.old_desktopLCP,
                        cls: item.old_desktopCLS,
                        tbt: item.old_desktopTBT,
                        si: item.old_desktopSI,
                    }));

                    const mobileBoosted = result.message.map(item => ({
                        url: item.url,
                        performance: homepageBoostStatus === 0 ? null : item.mobile_score,
                        fcp: homepageBoostStatus === 0 ? null : item.mobileFCP,
                        lcp: homepageBoostStatus === 0 ? null : item.mobileLCP,
                        cls: homepageBoostStatus === 0 ? null : item.mobileCLS,
                        tbt: homepageBoostStatus === 0 ? null : item.mobileTBT,
                        si: homepageBoostStatus === 0 ? null : item.mobileSI,
                    }));

                    const mobileOld = result.message.map(item => ({
                        url: item.url,
                        performance: item.old_mobile_score,
                        fcp: item.old_mobileFCP,
                        lcp: item.old_mobileLCP,
                        cls: item.old_mobileCLS,
                        tbt: item.old_mobileTBT,
                        si: item.old_mobileSI,
                    }));

                    updateSpeedContent('desktopContent', desktopBoosted, desktopOld);
                    updateSpeedContent('mobileContent', mobileBoosted, mobileOld);
                }
            } catch (error) {
                console.error('Error fetching speed data:', error);
            }
        }

        function updateSpeedContent(containerId, boostedData, oldData) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            const speedReport = document.createElement('div');
            speedReport.className = 'speed-report';

            boostedData.forEach((boosted, index) => {
                const old = oldData[index] || {};
                const boostedBox = createSpeedBox('Boosted Speed', boosted, true);
                const oldBox = createSpeedBox('Old Speed', old, false);

                speedReport.appendChild(boostedBox);
                speedReport.appendChild(oldBox);
            });

            container.appendChild(speedReport);
        }

        function createSpeedBox(title, data, isBoosted) {
            const box = document.createElement('div');
            box.className = `speed-box ${isBoosted ? 'boosted' : 'old'}`;

            box.innerHTML = `
                <h3>${title} -</h3>
                <a href="${data.url || '#'}" class="url" target="_blank">${data.url || '-'}</a>
                <div class="details">
                    <table class="table">
                        <thead>
                            <tr class="header-row">
                                <th colspan="1">Page Speed</th>
                                <th colspan="5">Core Web Vitals</th>
                            </tr>
                            <tr>
                                <th>Performance</th>
                                <th>FCP</th>
                                <th>LCP</th>
                                <th>CLS</th>
                                <th>TBT</th>
                                <th>SI</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.performance === null
                                ? `<tr><td colspan="6">No data available</td></tr>`
                                : `<tr>
                                    <td>${data.performance || '-'}</td>
                                    <td>${data.fcp || '-'}</td>
                                    <td>${data.lcp || '-'}</td>
                                    <td>${data.cls || '-'}</td>
                                    <td>${data.tbt || '-'}</td>
                                    <td>${data.si || '-'}</td>
                                </tr>`}
                        </tbody>
                    </table>
                </div>
            `;
            return box;
        }

        fetchSpeedData();
    </script>
    <?php
}
