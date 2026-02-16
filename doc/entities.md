### Entity Customization

The BlogBundle allows you to customize its base entities (Post, Category) to add properties or modify their behavior.
This system is based on Doctrine's `MappedSuperclass` and the `ResolveTargetEntityListener`.

#### 1. Extending an Entity

To add fields to a bundle entity, you must create an entity in your application that inherits from the bundle's entity.

For example, to add an `author` field to the `Post` entity:

```php
// src/Entity/Post.php
namespace App\Entity;

use Aropixel\BlogBundle\Entity\Post as BasePost;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'app_post')]
class Post extends BasePost
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $author = null;

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;
        return $this;
    }
}
```

#### 2. Configuring the Bundle

Once your entity is created, you must inform the bundle to use your class instead of its own. This is done in the configuration file `config/packages/aropixel_blog.yaml`:

```yaml
aropixel_blog:
    entities:
        Aropixel\BlogBundle\Entity\PostInterface: App\Entity\Post
```

The bundle will then handle:
1. Replacing all relations to `PostInterface` with your `App\Entity\Post` class.
2. Using your entity for the bundle's forms and controllers.

#### 3. List of Customizable Entities

Here are the interfaces you can configure in the `entities` section:

| Interface | Default Class |
| --- | --- |
| `Aropixel\BlogBundle\Entity\PostInterface` | `Aropixel\BlogBundle\Entity\Post` |
| `Aropixel\BlogBundle\Entity\PostTranslationInterface` | `Aropixel\BlogBundle\Entity\PostTranslation` |
| `Aropixel\BlogBundle\Entity\PostCategoryInterface` | `Aropixel\BlogBundle\Entity\PostCategory` |
| `Aropixel\BlogBundle\Entity\PostCategoryTranslationInterface` | `Aropixel\BlogBundle\Entity\PostCategoryTranslation` |

#### 4. Special Case for Translations

If you extend an entity like `Post` and want the new properties to be translatable, you will also need to extend `PostTranslation` and configure the corresponding interface.
