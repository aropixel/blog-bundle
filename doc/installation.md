# Installation

To install the Aropixel Blog Bundle, follow these steps:

### 1. Prerequisites

The Aropixel Blog Bundle requires the **Aropixel Admin Bundle** to be already installed and configured in your Symfony project.

### 2. Downloading the Bundle

Use Composer to add the bundle to your dependencies:

```bash
composer require aropixel/blog-bundle
```

### 3. Bundle Configuration

Create or modify the file `config/packages/aropixel_blog.yaml`:

```yaml
aropixel_blog:
    categories: 'all' # or 'none' if you don't want categories
```

### 4. Database Update

Apply migrations or update your schema:

```bash
php bin/console doctrine:schema:update --force
```

### 5. Including Routes

Add the bundle routes in `config/routes.yaml` or in a dedicated file:

```yaml
aropixel_blog:
    resource: '@AropixelBlogBundle/Resources/config/routing/aropixel.yml'
    prefix: /admin
```
