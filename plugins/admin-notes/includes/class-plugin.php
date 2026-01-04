<?php

declare(strict_types=1);

namespace AlexNXT\AdminNotesDemo;

if (!defined('ABSPATH')) {
  exit;
}

final class Plugin {
  public const META_KEY = '_an_demo_note';

  public function register(): void {
  // TODO: Další krok: metabox + uložení + capability + nonce.
  }
}
