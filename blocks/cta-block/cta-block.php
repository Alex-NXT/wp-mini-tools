<?php
/**
 * Plugin Name: CTA Block (Demo)
 * Description: Gutenberg CTA blok se server-side renderem – ukázka pro portfolio.
 * Version: 0.1.0
 * Author: Alex
 * License: MIT
 * Text Domain: cta-block-demo
 */

declare(strict_types=1);

namespace AlexNXT\CtaBlockDemo;

if (!defined('ABSPATH')) {
  exit;
}

add_action('init', function(): void {
  register_block_type(__DIR__, [
    'render_callback' => __NAMESPACE__ . '\render_block',
  ]);
});

function render_block(array $attributes): string {
  $text = trim((string) ($attributes['text'] ?? ''));
  $buttonText = trim((string) ($attributes['buttonText'] ?? ''));
  $url = trim((string) ($attributes['url'] ?? ''));
  $align = (string) ($attributes['align'] ?? 'wide');

  if ($text === '' && $buttonText === '') {
    return '';
  }

  $classes = ['anxt-cta'];
  if ($align !== '') {
    $classes[] = 'align' . sanitize_html_class($align);
  }

  $wrapperAttributes = get_block_wrapper_attributes([
    'class' => implode(' ', $classes),
  ]);

  ob_start();
  ?>
  <div <?php echo $wrapperAttributes; ?>>
    <div class="anxt-cta__inner">
      <?php if ($text !== ''): ?>
        <div class="anxt-cta__text">
          <?php echo wp_kses_post(wpautop($text)); ?>
        </div>
      <?php endif; ?>

      <?php if ($buttonText !== '' && $url !== ''): ?>
        <div class="anxt-cta__actions">
          <a class="anxt-cta__button" href="<?php echo esc_url($url); ?>">
            <?php echo esc_html($buttonText); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php
  return (string) ob_get_clean();
}
