<?php

declare(strict_types=1);

namespace AlexNXT\AdminNotesDemo;

if (!defined('ABSPATH')) {
  exit;
}

final class Plugin {
  public const META_KEY = '_an_demo_note';
  private const NONCE_ACTION = 'admin_notes_demo_save';
  private const NONCE_NAME = '_admin_notes_demo_nonce';

  public function register(): void {
    add_action('add_meta_boxes', [$this, 'register_metabox']);
    add_action('save_post', [$this, 'save_metabox']);

    add_filter('manage_post_posts_columns', [$this, 'add_admin_column']);
    add_action('manage_post_posts_custom_column', [$this, 'render_admin_column'], 10, 2);

    add_filter('manage_page_posts_columns', [$this, 'add_admin_column']);
    add_action('manage_page_posts_custom_column', [$this, 'render_admin_column'], 10, 2);
  }

  private function get_post_types(): array {
    // Výchozí post typy
    $post_types = ['post', 'page'];

    /**
     * Umožní přidat další post typy (CPT), kde se metabox zobrazí.
     *
     * @param array $post_types Seznam post typů.
     */
    $post_types = apply_filters('admin_notes_demo_post_types', $post_types);

    return array_values(array_filter(array_map('sanitize_key', (array) $post_types)));
  }

  public function register_metabox(): void {
    add_meta_box(
      'admin-notes-demo',
      __('Admin poznámka', 'admin-notes-demo'),
      [$this, 'render_metabox'],
      $this->get_post_types(),
      'side',
      'default'
    );
  }

  public function render_metabox(\WP_Post $post): void {
    $value = get_post_meta($post->ID, self::META_KEY, true);

    wp_nonce_field(self::NONCE_ACTION, self::NONCE_NAME);
    ?>
    <p>
      <label for="admin-notes-demo-field">
        <?php esc_html_e('Interní poznámka (viditelná jen v administraci):', 'admin-notes-demo'); ?>
      </label>
    </p>
    <textarea
      id="admin-notes-demo-field"
      name="admin_notes_demo_field"
      rows="5"
      style="width:100%;"
    ><?php echo esc_textarea((string) $value); ?></textarea>
    <?php
  }

  public function save_metabox(int $post_id): void {
    // Autosave / revision
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (wp_is_post_revision($post_id)) {
      return;
    }

    // Nonce
    if (
      !isset($_POST[self::NONCE_NAME]) ||
      !wp_verify_nonce($_POST[self::NONCE_NAME], self::NONCE_ACTION)
    ) {
      return;
    }

    // Capability
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    if (!isset($_POST['admin_notes_demo_field'])) {
      delete_post_meta($post_id, self::META_KEY);
      return;
    }

    $value = sanitize_textarea_field((string) $_POST['admin_notes_demo_field']);

    if ($value === '') {
      delete_post_meta($post_id, self::META_KEY);
      return;
    }

    update_post_meta($post_id, self::META_KEY, $value);
  }

  public function add_admin_column(array $columns): array {
    $columns['admin_notes_demo_note'] = __('Poznámka', 'admin-notes-demo');
    return $columns;
  }

  public function render_admin_column(string $column, int $post_id): void {
    if ($column !== 'admin_notes_demo_note') {
      return;
    }

    $value = (string) get_post_meta($post_id, self::META_KEY, true);
    $value = trim($value);

    if ($value === '') {
      echo '—';
      return;
    }

    $short = mb_substr($value, 0, 60);
    if (mb_strlen($value) > 60) {
      $short .= '…';
    }

    echo esc_html($short);
  }
}

