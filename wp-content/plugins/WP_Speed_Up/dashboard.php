<?php
function force_enqueue_dotlottie_script() {
    wp_enqueue_script(
        'dotlottie-player-js',
        plugin_dir_url(__FILE__) . 'assets/dotlottie-player.js',
        [],
        '1.0',
        true
    );
}
add_action('admin_enqueue_scripts', 'force_enqueue_dotlottie_script');


add_action('wp_ajax_save_boost_status', 'save_boost_status');
function save_boost_status() {
    // Check if mode is set and save it
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        update_option('boost_status', $status);
        wp_send_json_success('boosted');


    } else {
        wp_send_json_error('No status provided.');
    }
}

$boost_status = get_option('boost_status', 0); // Default to Basic



function save_connected_status() {
    // Check if the required data is received
    if (isset($_POST['connected_status']) && isset($_POST['connection_token'])) {

        // Sanitize and save each setting
        update_option('connection_token', sanitize_text_field($_POST['connection_token']));
        update_option('connected_status', sanitize_text_field($_POST['connected_status']));

        $hostname = parse_url(get_site_url(), PHP_URL_HOST);
        $connected_status = sanitize_text_field($_POST['connected_status']);
    
        // Send data to the external API
        $response = wp_remote_post('https://ausdigital.agency/api/wordpress/connected_status_update', [
            'method'    => 'POST',
            'headers'   => [
                'Content-Type' => 'application/json',
            ],
            'body'      => json_encode([
                'hostname'      => $hostname,
                'connected_status' => $connected_status,
            ]),
        ]);
    
        // Check for errors
        if (is_wp_error($response)) {
            error_log('Failed to send plugin status: ' . $response->get_error_message());
        } else {
            error_log('Plugin activation status sent successfully');
        }
        wp_send_json_success("connected status saved");
    } else {
        wp_send_json_error('Invalid request.');
    }
    wp_die(); // Required to terminate immediately and return a proper response

}

add_action('wp_ajax_save_connected_status', 'save_connected_status');
add_action('wp_ajax_nopriv_save_connected_status', 'save_connected_status'); // For non-logged-in users, if needed



function wp_speedy_dashboard() {
    


    // Include WordPress functions if not already included
if (!function_exists('get_plugins')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// Function to dynamically check for active cache-related plugins
function get_cache_plugins() {
    $active_plugins = get_option('active_plugins');
    $all_plugins = get_plugins();

    // Keywords commonly used by cache-related plugins
    $cache_keywords = ['cache', 'caching', 'optimizer', 'performance', 'speed', 'fast', 'wp rocket', 'w3 total', 'litespeed', 'autoptimize', 'super cache', 'minify', 'hummingbird', 'compression', 'asset', 'preload'];

    $detected_plugins = [];

    foreach ($active_plugins as $plugin) {
        // Skip "WordPress Speedy" plugin from detection
        if (stripos($all_plugins[$plugin]['Name'], 'WP Speedup') !== false) {
            continue;
        }

        foreach ($cache_keywords as $keyword) {
            if (strpos(strtolower($all_plugins[$plugin]['Name']), $keyword) !== false || 
                strpos(strtolower($all_plugins[$plugin]['Description']), $keyword) !== false) {
                $detected_plugins[] = $all_plugins[$plugin]['Name'];
                break; // No need to check other keywords for this plugin
            }
        }
    }
    return $detected_plugins;
}

// Display the warning popup if cache plugins are detected
$cache_plugins = get_cache_plugins();
if (!empty($cache_plugins)) {
    ?>
    <div id="cache-warning-popup" class="cache-warning-overlay">
        <div class="cache-warning-content">
            <img class="img__logo" src="<?php echo plugin_dir_url(__FILE__) . 'img/logo.png'; ?>" alt="WP Speedup">
            <h2 style="">⚠️ Warning: Optimization Plugins Detected</h2>
            <p style="font-weight: bold; color: #d9534f;">We have detected the following cache-related plugins active on your site:</p>
            <ul style="list-style-type: disc; text-align: left; padding-left: 20px;margin: 30px 0px;">
                <?php foreach ($cache_plugins as $plugin_name): ?>
                    <li><?php echo esc_html($plugin_name); ?> <span class="warning">(Deactivate Plugin)</span></li>
                <?php endforeach; ?>
            </ul>
            <p style="font-weight: bold;">To ensure optimal performance, please disable these plugins before using WP Speedup.</p>
            <a href="<?php echo admin_url('plugins.php'); ?>" class="go-to-plugins-btn">Go to Plugins Page</a>
        </div>
    </div>
    <?php
}

    // Retrieve the JWT token from WordPress options
    $jwt_token = get_option('connection_token');
    $is_connected = (get_option('connected_status') == 1)? true : false;

    ?>
    


      
      
    <div id="animation-container" lang="en" role="img" class="main2" bis_skin_checked="1" style="display:none;">
      <div id="animation" class="animation" style="background:#ffffffc7 ;" bis_skin_checked="1">
        <!--?lit$413275067$-->
         <dotlottie-player 
    src='https://lottie.host/ce2baafe-2f55-4b3f-8042-d3b04d48212c/FV1UcE5Bkc.lottie'  
    background='transparent'  
    speed='1'  
    style='width: 300px; height: 300px;' 
    loop 
    autoplay>
  </dotlottie-player>
        <p id="loader_text">-0.1 seconds of loading can result in +8% conversions.</p>
        <p>
          <span class="auto-type"></span>
          <span class="typed-cursor" aria-hidden="true">|</span>
        </p>
      </div>
      <!--?lit$413275067$-->
    </div>
      
    <div id="wpspeedy-connect">
        <!-- Header and Main Content -->
        <header class="header">
            <nav>
                <ol>
                    <li class="step passed"><?php esc_html_e('Connect to WP Speedup account', 'wpspeedy'); ?></li>
                    <li class="step current"><?php esc_html_e('Boost on 1 click', 'wpspeedy'); ?></li>
                </ol>
            </nav>
        </header>

        <main id="main">
            <div class="container">
                <div class="bg">
                    <!-- Background SVG and Design Elements -->
                    <div class="circle circle1"></div>
                    <div class="wave">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                            <path fill="#0099ff" fill-opacity="1" d="M0,96L60,96C120,96,240,96,360,128C480,160,600,224,720,256C840,288,960,288,1080,256C1200,224,1320,160,1380,128L1440,96L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                        </svg>
                    </div>
                    <div class="circle circle2"></div>
                    <div class="circle circle3"></div>  
                </div>

                <div class="major h-100">
                    <div class="flex justify-between items-center align-items-center">
                        <div class="content">
                            <h1><?php esc_html_e('Welcome to WP Speedup', 'wpspeedy'); ?></h1>
                            <p><?php esc_html_e('Let\'s boost your website\'s page load speed and improve your Core Web Vitals.', 'wpspeedy'); ?></p>

                            <div class="help">
                                <div class="main">
                                    <?php _e('Having trouble connecting? Explore our <a href="#" class="btn-manual-connect">manual connect</a> option, browse our <a href="https://help.websitespeedy.com/faqs" target="_blank">FAQ section</a>, or reach out to our <a href="https://help.websitespeedy.com/admin/dashboard" target="_blank">support team</a>.', 'wpspeedy'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="absolute" style="display: flex; flex-direction: column; gap:10px; right: 20px;">
                            <h4 style="width: 100%;" id="heading-boosty"> Boost Status </h4>
                            <div class="flex gap-2">
                                <div id="main-boosty">
                                    <label class="switch">
                                      <input id="boosty" type="checkbox" status=<?=get_option('boost_status')?> <?=(get_option('boost_status') == 1)?'checked':'';?>>
                                      <span class="slider round">
                                          <p class="display-text right" <?=(get_option('boost_status') == 1)?'style="display:none;"':'style="display:flex;"';?>>OFF</p>
                                          <p class="display-text left" <?=(get_option('boost_status') == 1)?'style="display:flex;"':'style="display:none;"';?>>ON</p>
                                      </span>
                                    </label>
                                </div>
                                <div>
                                    <a href="javascript:void(0)" id="purge-cache-button" class="btn btn-primary">Purge Cache</a>
                                </div>
                            </div>
                            <p id="last_purged_p"><b>Last Purged:</b>
                                <?php
                                  $last_purge_time = get_option('last_cache_purge_time');
                                   if ($last_purge_time) {
                                       echo  esc_html($last_purge_time);
                                   } else {
                                       echo '<p>No cache purge has been recorded yet.</p>';
                                   }
                               ?>
                           </p>
                        </div>
                    </div>

                    <div class="image-div">
                        <img src="<?php echo plugin_dir_url(__FILE__) . 'img/wordpressspeedy.png'; ?>" alt="WP Speedup">
                        <a href="#" id="connect-btn" class="btn btn-primary btn-xl w-100"><?php esc_html_e('Connect', 'wpspeedy'); ?></a>
                        <span class="align-items-center gap-2" style="margin-bottom:20px;" id="view_dash" <?=(!$is_connected)? 'style="display:none;"': '';?>>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
                                <path d="M8.90039 7.56023C9.21039 3.96023 11.0604 2.49023 15.1104 2.49023H15.2404C19.7104 2.49023 21.5004 4.28023 21.5004 8.75023V15.2702C21.5004 19.7402 19.7104 21.5302 15.2404 21.5302H15.1104C11.0904 21.5302 9.24039 20.0802 8.91039 16.5402" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <g opacity="0.4">
                                <path d="M14.9991 12H3.61914" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.85 8.65039L2.5 12.0004L5.85 15.3504" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </svg>
                            <a href="javascript:void(0)" onclick="disconnect();">Disconnect</a> 
                        </span>
                        <div class="copyright">
                            <div class="area">
                                <?php _e('© 2025 <a href="https://wp.websitespeedy.com" class="btn-manual-connect">WP Speedup</a> By <a href="https://makkpressapps.com" target="_blank">MakkPress</a>. All rights reserved.', 'wpspeedy'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <a id="open_dashboard" href="https://ausdigital.agency/en/install-plugin" target="_blank"></a>

    <script>
    
var global_token_variable = '';
    
        document.addEventListener('DOMContentLoaded', function() {
            const connectBtn = document.getElementById('connect-btn');
            const jwtToken = '<?php echo esc_js($jwt_token); ?>';
            
            global_token_variable = jwtToken;

            if (!jwtToken) {
                console.warn("JWT Token is missing. Opening login popup.");
                connectBtn.textContent = 'Connect';
                updateButtonToConnect(); 
                connectBtn.addEventListener('click', function(event) {
                    event.preventDefault();
                    openLoginPopup();
                });
                return;
            }

            // Fetch the connection status from the Next.js backend
            fetch('https://ausdigital.agency/api/wordpress/connected_status_update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token: jwtToken, action: 'fetch', hostname: window.location.hostname })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                console.log("Fetch response:", data); // Debugging output
                if (data.status === "success" && typeof data.connected === 'boolean') {
                    if (data.connected) {
                        updateButtonToViewDashboard(jwtToken);
                        document.getElementById('view_dash').style.display = 'flex';

                        if(data.boost){

                            document.getElementById('boosty').checked = true;
                            document.querySelector('.slider .left').style.display = 'flex';
                            document.querySelector('.slider .right').style.display = 'none';
                            saveBoostStatus(1, 0);
            
                        }else{

                            document.getElementById('boosty').checked = false;
                            document.querySelector('.slider .left').style.display = 'none';
                            document.querySelector('.slider .right').style.display = 'flex';
                            saveBoostStatus(0, 0);

                        }
   
                    } else {
                        updateButtonToConnect(); 
                                      
                    }
                } else {
                    console.error("Error fetching status:", data.message);
                    updateButtonToConnect();

                    document.getElementById('boosty').checked = false
                }
            })
            .catch(error => {
                console.error("Error fetching connection status:", error);
                updateButtonToConnect();
            });

            connectBtn.addEventListener('click', function(event) {
                event.preventDefault();
                if (connectBtn.textContent === 'View Dashboard') {
                    window.open('https://ausdigital.agency?token=' + jwtToken, '_blank');
                } else {
                    openLoginPopup();
                }
            });

            




        });


        var  dashboardOpened = false;


        function openLoginPopup() {

            // let dashboardOpened = false;
            
                const popup = window.open(`https://ausdigital.agency/en/plugin-authenticate?site=${window.location.hostname}`, 'WP Speedy Authentication', 'width=450,height=500');
                if (!popup) {
                    alert('Popup blocked. Please allow popups for this website.');
                    return;
                }
                window.addEventListener('message', function(event) {
                    
                    console.log(event.data);
                    
                    var site_found = 0;
                    
                    event.data.site.forEach((site_data) => {
                        
                        if(site_data.website_url.includes(window.location.hostname)){
                            
                            site_found = 1;
                            
                        }
                        
                    });

                    if (event.origin === 'https://ausdigital.agency' && event.data.status === 'connected' && site_found == 1 ) {

                        fetch('https://ausdigital.agency/api/wordpress/connected_status_update', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ token: event.data.token, action: 'update', hostname: window.location.hostname })
                        })
                        .then(response => response.json())
                        .then(() => {
                                        fetch(ajaxurl, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded'
                                            },

                                            body: new URLSearchParams({

                                                action: 'save_connected_status',

                                                connected_status: 1,

                                                connection_token: event.data.token,

                                                type: 'login'

                                            })

                                        })

                                        .then(response => response.json())

                                        .then(data => { 
                                            updateButtonToViewDashboard(event.data.token);
                                            global_token_variable = event.data.token;
                                            document.getElementById('view_dash').style.display = 'block';
                                            popup.close();

                                       

// Then modify the click trigger to:
                                        if (!dashboardOpened) {
                                            document.querySelector('#open_dashboard').click();
                                            dashboardOpened = true;
                                        }
                                        })

                                        .catch(error => console.error(error));

                        })
                        .catch(error => {
                            console.error("Error updating status:", error);
                        });
                    }
                });


                
            }

         

        function updateButtonToViewDashboard(token) {
            document.getElementById('connect-btn').textContent = 'View Dashboard';
            document.getElementById('connect-btn').href = 'https://ausdigital.agency/?token=' + token;
            document.getElementById('connect-btn').setAttribute('target', '_blank');
            document.getElementById('connect-btn').style.marginBottom = '0px';

            const button = document.getElementById('connect-btn');

            const clone = document.getElementById('connect-btn').cloneNode(true);
            button.parentNode.replaceChild(clone, button);

    document.getElementById('speedy-status-indicator').innerHTML = '<span style="color: green;">●</span> Connected <span class="boost-indicator"><?=(get_option('boost_status') == 1)?'(Boosted)':'(Not Boosted)';?><span>';

    document.getElementById('heading-boosty').style.display = 'block';
document.getElementById('main-boosty').style.display = 'block';

document.getElementById('view_dash').style.display = 'block';


   
}
        
        
                  function updateButtonToConnect() {
                document.getElementById('connect-btn').textContent = 'Connect';
                document.getElementById('connect-btn').removeAttribute('href');
                document.getElementById('connect-btn').removeAttribute('target');
                document.getElementById('connect-btn').style.marginBottom = '20px';

                document.getElementById('speedy-status-indicator').innerHTML = '<span style="color: red;">●</span> Disconnected <span class="boost-indicator"><span>';

                document.getElementById('heading-boosty').style.display = 'none';
document.getElementById('main-boosty').style.display = 'none';

document.getElementById('view_dash').style.display = 'none';


document.getElementById('connect-btn').addEventListener('click', function(event) {
                event.preventDefault();
                if (document.getElementById('connect-btn').textContent === 'View Dashboard') {
                    window.open('https://ausdigital.agency?token=' + jwtToken, '_blank');
                } else {
                    openLoginPopup();
                }
            });


            }
        
        
        
        // Function to handle disconnect (logout) logic via a popup
function disconnect() {
  // Debugging line



  if(confirm('Are you sure you want to disconnect?')){

    console.log("disconnect approved"); 

    sendLogoutRequest();
    return;
  }


  console.log("disconnect denied");

  // Open a popup window to the logout URL on ausdigital.agency
//   const popup = window.open('https://ausdigital.agency/logout-popup', 'logoutPopup', 'width=950,height=700');

  // Monitor when the popup closes
//   const popupCheckInterval = setInterval(() => {
//     if (popup.closed) {
//       clearInterval(popupCheckInterval);
//       console.log('Popup closed, proceeding with API logout.');

      // Now send the fetch request to the server to log out
    //   sendLogoutRequest();
    // }
//   }, 500);
}


// Function to send the logout request to the server
function sendLogoutRequest() {
  // Retrieve the session token from cookies
  const token = '<?=get_option('connection_token')?>' || global_token_variable;

  if (!token) {
    alert('No session token found.');
    document.getElementById('connect-wpspeedy').innerText = 'Connect';
    return;
  }


  jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'save_connected_status',
            connected_status: 0,
            connection_token: '',
            type: 'logout'

        },
        success: function(response) {
            console.log(response); // Log the response if needed
                // statusIndicator.innerHTML = '<span style="color: red;">●</span> Disconnected';

                     // Change the button text back to "Connect"
        document.getElementById('view_dash').style.display = 'none';
            updateButtonToConnect();
        },
        error: function(error) {
            console.error(error);
            alert('Failed to save settings.');
        }
    });

  // Send the token to the server to log out
//   fetch('https://ausdigital.agency/api/user/logout', {
//     method: 'POST',
//     headers: {
//       'Content-Type': 'application/json',
//     },
//     credentials: 'include', // Include credentials for cross-origin requests
//     body: JSON.stringify({ token }),
//   })
//     .then(response => response.json())
//     .then(data => {
//       if (data.status === 'success') {


//         // Change the button text back to "Connect"
//         document.getElementById('view_dash').style.display = 'none';
//             updateButtonToConnect();


//         // Reload the page to reset the state
//       } else {
//         alert('Failed to log out via API.');
//       }
//     })
//     .catch(error => {
//       console.error('Logout error:', error);
//     });

dashboardOpened = false;
}



// Define the function to handle the cache purge
function purgeCache() {
    // Show the loader before the request
    document.getElementById('animation-container').style.display = 'block';

    // Prepare the data to send
    const data = new URLSearchParams();
    data.append('action', 'purge_cache'); // Action name
    data.append('nonce', purgeCacheAjax.nonce); // Nonce for security

    // Send the AJAX request using Fetch API
    fetch(purgeCacheAjax.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data,
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then((response) => {
            if (response.success) {
                // Cache purge was successful
                setTimeout(() => {
                    document.getElementById('animation-container').style.display = 'none';


                    document.getElementById('last_purged_p').innerHTML = `<b>Last Purged: </b>${response.data.time}`;

                }, 10000);

                console.log(response);
            } else {
                alert('Cache purge failed!');
            }
        })
        .catch((error) => {
            // Handle errors
            console.error('AJAX request failed:', error);
            alert('AJAX request failed.');
            document.querySelector('.main_cleanup').style.display = 'none';
        });
}



document.querySelector('#purge-cache-button').addEventListener('click', (e) => {
    e.preventDefault(); // Prevent default behavior
    purgeCache(); // Call the function
});




  const quotes = [
            "Webpages should take only 1 or 2 seconds to load to reduce bounce rate at 9% - Research by Pingdom",
            "1 in 3 consumers say they’ll leave a brand they love after just one bad experience - Research by PWC",
            "500 milliseconds of extra loading results in a traffic drop of 20% - Research by Google",
            "Every extra 100 milliseconds of loading decreases sales by 1% - Research by Amazon",
            "With a 0.1s improvement in site speed, retail consumers spent almost 10% more - Research by Deloitte",
            "An ecommerce site that loads within 1 second converts 2.5x better than a site that loads in 5 seconds - Research by Portent",
            "36.8% of shoppers are less likely to return if page loads slowly - Research by Google"
        ];

        const quoteDisplay = document.querySelector(".auto-type");
        let quoteIndex = 0;
        let charIndex = 0;

        function typeQuote() {
            if (charIndex < quotes[quoteIndex].length) {
                // Add the next character
                quoteDisplay.innerHTML += quotes[quoteIndex].charAt(charIndex) === ' ' ? '&nbsp;' : quotes[quoteIndex].charAt(charIndex);
                charIndex++;
                // Set a slight delay for typing effect
                setTimeout(typeQuote, 50); // Adjust the speed by changing 50
            } else {
                // Wait before clearing the quote and typing the next one
                setTimeout(() => {
                    charIndex = 0; // Reset character index for next quote
                    quoteIndex = (quoteIndex + 1) % quotes.length; // Move to the next quote
                    quoteDisplay.innerHTML = ""; // Clear the current quote
                    typeQuote(); // Start typing the next quote
                }, 2000); // 2 seconds delay between quotes
            }
        }

        // Start typing the first quote
        typeQuote();
        
        
        function reset_boost(){
            
                // Show the loader before the request
    document.getElementById('animation-container').style.display = 'block';
            
            
            const hostname = window.location.hostname; // Gets the current site's hostname

fetch('https://ausdigital.agency/api/wordpress/boost_status_update', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        hostname: hostname, // Sends the hostname in the body
        token: global_token_variable,
        boost_status: 0
    }),
})
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data); // Logs the response data
        
           setTimeout(() => {
                    document.getElementById('animation-container').style.display = 'none';

 
                }, 10000);
    })
    .catch(error => {
        console.error('Error:', error); // Logs any errors
    });
            
            
        }



      function  boost_toggle(status){

        const hostname = window.location.hostname; 


        fetch('https://ausdigital.agency/api/wordpress/boost_status_update', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        hostname: hostname, // Sends the hostname in the body
        token: global_token_variable,
        boost_status: status
    }),
})



      }


      function saveBoostStatus(status, loader = 1) {
        if(loader == 1){

            document.getElementById('animation-container').style.display = 'block';

        }
    fetch(ajaxurl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Form-encoded data
        },
        body: new URLSearchParams({
            action: 'save_boost_status', // Action tied to the WordPress function
            status: status, // The status value to save
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Success:', data.data); // Handle success response
            // alert('Status saved successfully: ' + data.data);
            setTimeout(() => {
                    document.getElementById('animation-container').style.display = 'none';


                    if(status == 1){

                        document.getElementById('speedy-status-indicator').innerHTML = '<span style="color: green;">●</span> Connected <span class="boost-indicator">(Boosted)<span>';

                    }else{

                        document.getElementById('speedy-status-indicator').innerHTML = '<span style="color: green;">●</span> Connected <span class="boost-indicator">(Not Boosted)<span>';

                    }
 
                }, 10000);
        } else {
            console.log('Error:', data.data); // Handle error response
            // alert('Failed to save status: ' + data.data);
        }
    })
    .catch(error => {
        console.error('Request failed:', error);
    });
}


document.getElementById('boosty').addEventListener('change', function(event){

var checked = event.target.checked;

 if(checked){

     document.querySelector('.slider .left').style.display = 'flex';
     document.querySelector('.slider .right').style.display = 'none';
     boost_toggle(1);
     saveBoostStatus(1);
     
 }else{

      document.querySelector('.slider .left').style.display = 'none';
     document.querySelector('.slider .right').style.display = 'flex';
     boost_toggle(0);
     saveBoostStatus(0);
     
 }
});


    </script>
    <?php
}

