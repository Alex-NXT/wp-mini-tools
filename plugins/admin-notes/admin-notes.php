<?php
/**
 * Plugin Name: Admin Notes (Demo)
 * Description: Jednoduché interní poznámky v administraci – ukázkový plugin pro portfolio.
 * Version: 0.1.0
 * Author: Alex
 * License: MIT
 * Text Domain: admin-notes-demo
 */

declare(strict_types=1);

namespace AlexNXT\AdminNotesDemo;

if (!defined('ABSPATH')) {
  exit;
}

require_once __DIR__ . '/includes/class-plugin.php';

function run(): void {
  $plugin = new Plugin();
  $plugin->register();
}

add_action('plugins_loaded', __NAMESPACE__ . '\run');
