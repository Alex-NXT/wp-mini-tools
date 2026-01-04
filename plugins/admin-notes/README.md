# Admin Notes (Demo)

Lehký WordPress plugin, který přidá interní poznámku k příspěvkům/stránkám (viditelnou pouze v administraci).

## Funkce
- Metabox v editoru (post/page)
- Bezpečné ukládání (nonce + capability checks)
- Sloupec v přehledu příspěvků/stránek (rychlý náhled poznámky)
- Možnost rozšířit podporované post typy přes filter

## Instalace
1. Stáhni ZIP nebo naklonuj repozitář
2. Nahraj do `wp-content/plugins/admin-notes`
3. Aktivuj plugin v administraci

## Rozšíření (CPT)
```php
add_filter('admin_notes_demo_post_types', function(array $types): array {
  $types[] = 'product';
  return $types;
});

## Changelog
- 0.2.0: metabox + sloupec v přehledu + filter pro CPT
- 0.1.0: scaffold
