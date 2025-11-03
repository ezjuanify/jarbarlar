<?php

class Test_Htaccess_Handler {
    /**
     * Add custom rules to the .htaccess file
     */
    public static function update_htaccess() {
        $htaccess_file = ABSPATH . '.htaccess';
        $rules = <<<EOD
        # BEGIN Test Wordpress Speedy

# Check if the query string does contain "withspeedy"
<If "%{QUERY_STRING} =~ /withspeedy/">
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType image/jpg "access 1 year"
        ExpiresByType image/jpeg "access 1 year"
        ExpiresByType image/gif "access 1 year"
        ExpiresByType image/png "access 1 year"
        ExpiresByType text/css "access 1 month"
        ExpiresByType text/html "access 1 month"
        ExpiresByType application/pdf "access 1 month"
        ExpiresByType text/x-javascript "access 1 month"
        ExpiresByType application/x-shockwave-flash "access 1 month"
        ExpiresByType image/x-icon "access 1 year"
        ExpiresDefault "access 1 month"
    </IfModule>

    <IfModule mod_deflate.c>
        # Compress HTML, CSS, JavaScript, Text, XML, and fonts
        AddOutputFilterByType DEFLATE text/html text/plain text/xml
        AddOutputFilterByType DEFLATE text/css
        AddOutputFilterByType DEFLATE application/javascript
        AddOutputFilterByType DEFLATE application/x-javascript
        AddOutputFilterByType DEFLATE text/javascript
        AddOutputFilterByType DEFLATE application/json
        AddOutputFilterByType DEFLATE application/xml
        AddOutputFilterByType DEFLATE font/woff2
    </IfModule>
</If>

# END Test Wordpress Speedy

EOD;

        // Check if .htaccess exists and is writable
        if (is_writable($htaccess_file)) {
            $current_content = file_get_contents($htaccess_file);
            if ($current_content === false) {
                error_log('Failed to read .htaccess file');
                return;
            }

            // Append rules only if they are not already present
            if (strpos($current_content, '# BEGIN Test Wordpress Speedy') === false) {
                $result = file_put_contents($htaccess_file, $rules, FILE_APPEND | LOCK_EX);
                if ($result === false) {
                    error_log('Failed to write to .htaccess file');
                }
            }
        } else {
            error_log('.htaccess is not writable');
        }
    }

    /**
     * Remove custom rules from the .htaccess file
     */
    public static function remove_htaccess_code() {
        $htaccess_file = ABSPATH . '.htaccess';
        if (file_exists($htaccess_file) && is_writable($htaccess_file)) {   
            $content = file_get_contents($htaccess_file);
            if ($content === false) {
                error_log('Failed to read .htaccess file');
                return;
            }

            // Define the start and end markers for the rules
            $rules_start = "# BEGIN Test Wordpress Speedy";
            $rules_end = "# END Test Wordpress Speedy";

            // Locate and remove the custom rules
            $start_pos = strpos($content, $rules_start);
            $end_pos = strpos($content, $rules_end) + strlen($rules_end);

            if ($start_pos !== false && $end_pos !== false) {
                $content = substr_replace($content, '', $start_pos, $end_pos - $start_pos);
                $result = file_put_contents($htaccess_file, $content, LOCK_EX);
                if ($result === false) {
                    error_log('Failed to update .htaccess file');
                }
            }
        } else {
            error_log('.htaccess is not writable');
        }
    }
}
