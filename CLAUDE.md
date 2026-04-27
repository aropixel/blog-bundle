# CLAUDE.md — BlogBundle

> **IMPORTANT — maintenance safeguard**
> This file documents implicit contracts that are not apparent from reading the code.
> **Any change to an invariant listed here must be reflected here immediately.**
> A stale CLAUDE.md is actively misleading — better to delete it than let it lie.

## Documentation

- [Index](doc/index.md)
- [Installation](doc/installation.md)
- [Entities](doc/entities.md)
- [i18n](doc/i18n.md)

---

## Non-obvious invariants

### `Post` vs `PostCategory` — MappedSuperclass status

- `Post` is `#[ORM\MappedSuperclass]` — instantiate directly with `new Post()`.
- `PostCategory` is `#[ORM\Entity]` (not a MappedSuperclass) — instantiate directly with `new PostCategory()`.

### `PostCategory::$position` — required field

- `$position` is `NOT NULL` in the database and annotated `#[Gedmo\SortablePosition]`.
- **Calling `setPosition()` is mandatory** on creation — omitting it causes an SQL error on insert.

### Translation class constructors — different signatures

These two classes have different signatures despite serving the same purpose:

```php
// PostCategoryTranslation — all params optional
new PostCategoryTranslation(?string $locale, ?string $field, ?string $value)

// PostTranslation — locale and field are required
new PostTranslation(string $locale, string $field, ?string $value)
```

### Slug on `Post`

- `Post::$slug` is a Gedmo Slug on `['title']` — **never call `setSlug()`**.
- The slug is generated automatically on the first `flush()` after setting the title.

### Translation pattern (Gedmo Personal Translation)

In multilingual mode, the value set directly on the entity serves as the **English fallback** (Gedmo returns this value when no translation exists for the requested locale):

```php
$post->setTitle('English title');           // Gedmo fallback
$post->addTranslation(new PostTranslation('fr', 'title', 'Titre français'));
$post->addTranslation(new PostTranslation('de', 'title', 'Deutschtitel'));
```

In monolingual mode (single language), use the setter directly without adding any translations.
