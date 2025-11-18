<?php
/**
 * OKTheme GitHub Updater (Safe Version)
 */

if (!defined('ABSPATH')) exit;

class OKTheme_GitHub_Updater {

    private $theme_slug;
    private $theme_version;
    private $api_url;

    public function __construct() {
        $theme = wp_get_theme();
        $this->theme_slug    = $theme->get_stylesheet();
        $this->theme_version = $theme->get('Version');

        $this->api_url = 'https://api.github.com/repos/ijayasurya/oktheme/releases/latest';

        add_filter('site_transient_update_themes', [$this, 'check_for_update']);
        add_filter('themes_api', [$this, 'theme_info'], 10, 3);
    }

    /** Check GitHub for update */
    public function check_for_update($transient) {

        if (empty($transient->checked)) return $transient;

        $remote = $this->get_remote_data();

        // Missing response → abort safely
        if (!$remote || !isset($remote->tag_name)) {
            return $transient;
        }

        // Clean version like v1.0.2 → 1.0.2
        $remote_version = ltrim($remote->tag_name, 'v');

        // Ensure asset exists
        if (empty($remote->assets) || empty($remote->assets[0]->browser_download_url)) {
            return $transient;
        }

        $zip_url = $remote->assets[0]->browser_download_url;

        if (version_compare($this->theme_version, $remote_version, '<')) {
            $transient->response[$this->theme_slug] = [
                'theme'       => $this->theme_slug,
                'new_version' => $remote_version,
                'url'         => $remote->html_url,
                'package'     => $zip_url,
            ];
        }

        return $transient;
    }

    /** Theme popup (details) */
    public function theme_info($false, $action, $args) {

        if ($action !== 'theme_information' || $args->slug !== $this->theme_slug) {
            return $false;
        }

        $remote = $this->get_remote_data();
        if (!$remote || !isset($remote->tag_name)) return $false;

        $remote_version = ltrim($remote->tag_name, 'v');

        $zip_url = (!empty($remote->assets[0]->browser_download_url))
            ? $remote->assets[0]->browser_download_url
            : '';

        return (object)[
            'name'          => $this->theme_slug,
            'slug'          => $this->theme_slug,
            'version'       => $remote_version,
            'author'        => 'OKTheme',
            'download_link' => $zip_url,
            'sections'      => [
                'description' => 'Auto-updated from GitHub.',
                'changelog'   => !empty($remote->body) ? wpautop($remote->body) : 'No changelog.',
            ],
        ];
    }

    /** Fetch GitHub Release JSON safely */
    private function get_remote_data() {

        $request = wp_remote_get($this->api_url, [
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'WordPress-' . home_url()
            ]
        ]);

        if (is_wp_error($request)) return false;

        $body = wp_remote_retrieve_body($request);
        if (!$body) return false;

        $json = json_decode($body);

        // Ensure valid release structure
        if (!is_object($json) || isset($json->message)) {
            return false;
        }

        return $json;
    }
}

new OKTheme_GitHub_Updater();
