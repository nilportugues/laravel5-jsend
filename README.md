# Laravel 5 JSend Transformer Package


[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/laravel5-jsend-transformer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nilportugues/laravel5-jsend-transformer/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/aa4fca95-5720-4d07-b35f-3d26e9f0e9e4/mini.png?)](https://insight.sensiolabs.com/projects/aa4fca95-5720-4d07-b35f-3d26e9f0e9e4) 
[![Latest Stable Version](https://poser.pugx.org/nilportugues/laravel5-jsend/v/stable?)](https://packagist.org/packages/nilportugues/laravel5-jsend) 
[![Total Downloads](https://poser.pugx.org/nilportugues/laravel5-jsend/downloads?)](https://packagist.org/packages/nilportugues/laravel5-jsend) 
[![License](https://poser.pugx.org/nilportugues/laravel5-jsend/license?)](https://packagist.org/packages/nilportugues/laravel5-jsend) 
[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://paypal.me/nilportugues)

*Compatible with Laravel 5.0, 5.1 & 5.2*

## Installation

Use [Composer](https://getcomposer.org) to install the package:

```
$ composer require nilportugues/laravel5-jsend
```




## Laravel 5 / Lumen Configuration

**Step 1: Add the Service Provider**

**Laravel**

Open up `config/app.php` and add the following line under `providers` array:

```php
'providers' => [

    //...
    \NilPortugues\Laravel5\JSend\Laravel5JSendServiceProvider::class,
],
```

**Lumen**

Open up `bootstrap/app.php`and add the following lines before the `return $app;` statement:

```php
$app->register(\NilPortugues\Laravel5\JSend\Laravel5JSendServiceProvider::class);
$app->configure('jsend');
```

Also, enable Facades by uncommenting:

```php
$app->withFacades();
```


**Step 2: Add the mapping**

Create a `jsend.php` file in `config/` directory. This file should return an array returning all the class mappings.


**Step 3: Usage**

For instance, lets say the following object has been fetched from a Repository , lets say `PostRepository` - this being implemented in Eloquent or whatever your flavour is:

```php
use Acme\Domain\Dummy\Post;
use Acme\Domain\Dummy\ValueObject\PostId;
use Acme\Domain\Dummy\User;
use Acme\Domain\Dummy\ValueObject\UserId;
use Acme\Domain\Dummy\Comment;
use Acme\Domain\Dummy\ValueObject\CommentId;

//$postId = 9;
//PostRepository::findById($postId); 

$post = new Post(
  new PostId(9),
  'Hello World',
  'Your first post',
  new User(
      new UserId(1),
      'Post Author'
  ),
  [
      new Comment(
          new CommentId(1000),
          'Have no fear, sers, your king is safe.',
          new User(new UserId(2), 'Barristan Selmy'),
          [
              'created_at' => (new \DateTime('2015/07/18 12:13:00'))->format('c'),
              'accepted_at' => (new \DateTime('2015/07/19 00:00:00'))->format('c'),
          ]
      ),
  ]
);
```

And a series of mappings, placed in `config/jsend.php`, that require to use *named routes* so we can use the `route()` helper function:

```php
<?php
//config/jsend.php
return [
    [
        'class' => 'Acme\Domain\Dummy\Post',
        'alias' => 'Message',
        'aliased_properties' => [
            'author' => 'author',
            'title' => 'headline',
            'content' => 'body',
        ],
        'hide_properties' => [

        ],
        'id_properties' => [
            'postId',
        ],
        'urls' => [
            'self' => ['name' => 'get_post'], //named route
            'comments' => ['name' => 'get_post_comments'], //named route
        ],
    ],
    [
        'class' => 'Acme\Domain\Dummy\ValueObject\PostId',
        'alias' => '',
        'aliased_properties' => [],
        'hide_properties' => [],
        'id_properties' => [
            'postId',
        ],
        'urls' => [
            'self' => ['name' => 'get_post'], //named route
        ],
    ],
    [
        'class' => 'Acme\Domain\Dummy\User',
        'alias' => '',
        'aliased_properties' => [],
        'hide_properties' => [],
        'id_properties' => [
            'userId',
        ],
        'urls' => [
            'self' => ['name' => 'get_user'], //named route
            'friends' => ['name' => 'get_user_friends'], //named route
            'comments' => ['name' => 'get_user_comments'], //named route
        ],
    ],
    [
        'class' => 'Acme\Domain\Dummy\ValueObject\UserId',
        'alias' => '',
        'aliased_properties' => [],
        'hide_properties' => [],
        'id_properties' => [
            'userId',
        ],
        'urls' => [
            'self' => ['name' => 'get_user'], //named route
            'friends' => ['name' => 'get_user_friends'], //named route
            'comments' => ['name' => 'get_user_comments'], //named route
        ],
    ],
    [
        'class' => 'Acme\Domain\Dummy\Comment',
        'alias' => '',
        'aliased_properties' => [],
        'hide_properties' => [],
        'id_properties' => [
            'commentId',
        ],
        'urls' => [
            'self' => ['name' => 'get_comment'], //named route
        ],
    ],
    [
        'class' => 'Acme\Domain\Dummy\ValueObject\CommentId',
        'alias' => '',
        'aliased_properties' => [],
        'hide_properties' => [],
        'id_properties' => [
            'commentId',
        ],
        'urls' => [
            'self' => ['name' => get_comment'], //named route
        ],
    ],
];

```

The named routes belong to the `app/Http/routes.php`. Here's a sample for the routes provided mapping:

**Laravel**

```php
Route::get(
  '/post/{postId}',
  ['as' => 'get_post', 'uses' => 'PostController@getPostAction']
);

Route::get(
  '/post/{postId}/comments',
  ['as' => 'get_post_comments', 'uses' => 'CommentsController@getPostCommentsAction']
);

//...
```

**Lumen**

```php
$app->get(
  '/post/{postId}',
  ['as' => 'get_post', 'uses' => 'PostController@getPostAction']
);

$app->get(
  '/post/{postId}/comments',
  ['as' => 'get_post_comments', 'uses' => 'CommentsController@getPostCommentsAction']
);

//...
```

All of this set up allows you to easily use the `JSendSerializer` service as follows:

```php
<?php

namespace App\Http\Controllers;

use Acme\Domain\Dummy\PostRepository;
use NilPortugues\Laravel5\JSend\JSendSerializer;
use NilPortugues\Laravel5\JSend\JSendResponseTrait;


class PostController extends \Laravel\Lumen\Routing\Controller
{
    use JSendResponseTrait;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var JSendSerializer
     */
    private $serializer;

    /**
     * @param PostRepository $postRepository
     * @param JSendSerializer $jSendSerializer
     */
    public function __construct(PostRepository $postRepository, JSendSerializer $jSendSerializer)
    {
        $this->postRepository = $postRepository;
        $this->serializer = $jSendSerializer;
    }

    /**
     * @param int $postId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPostAction($postId)
    {
        $post = $this->postRepository->findById($postId);

        /** @var \NilPortugues\Api\JSend\JSendTransformer $transformer */
        $transformer = $this->serializer->getTransformer();
        $transformer->setSelfUrl(route('get_post', ['postId' => $postId]));
        $transformer->setNextUrl(route('get_post', ['postId' => $postId+1]));

        return $this->response($this->serializer->serialize($post));
    }
}
```

**Output:**

```
HTTP/1.1 200 OK
Cache-Control: private, max-age=0, must-revalidate
Content-type: application/json; charset=utf-8
```

```json
{
    "status": "success",
    "data": {
        "post_id": 9,
        "title": "Hello World",
        "content": "Your first post",
        "author": {
            "user_id": 1,
            "name": "Post Author"
        },
        "comments": [
            {
                "comment_id": 1000,
                "dates": {
                    "created_at": "2015-07-18T12:13:00+00:00",
                    "accepted_at": "2015-07-19T00:00:00+00:00"
                },
                "comment": "Have no fear, sers, your king is safe.",
                "user": {
                    "user_id": 2,
                    "name": "Barristan Selmy"
                }
            }
        ]
    },
    "links": {
        "self": {
            "href": "http://example.com/post/9"
        },
        "next": {
            "href": "http://example.com/post/10"
        }
    }
}
```

#### Response objects (JSendResponseTrait)

The following `JSendResponseTrait` methods are provided to return the right headers and HTTP status codes are available:

```php
    private function errorResponse($message, $code = 500, $data = null);
    private function failResponse($json);
    private function response($json);
```    

<br>
## Quality

To run the PHPUnit tests at the command line, go to the tests directory and issue phpunit.

This library attempts to comply with [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/), [PSR-4](http://www.php-fig.org/psr/psr-4/) and [PSR-7](http://www.php-fig.org/psr/psr-7/).

If you notice compliance oversights, please send a patch via [Pull Request](https://github.com/nilportugues/laravel5-jsend-transformer/pulls).


<br>
## Contribute

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker](https://github.com/nilportugues/laravel5-jsend-transformer/issues/new).
* You can grab the source code at the package's [Git repository](https://github.com/nilportugues/laravel5-jsend-transformer).


<br>
## Support

Get in touch with me using one of the following means:

 - Emailing me at <contact@nilportugues.com>
 - Opening an [Issue](https://github.com/nilportugues/laravel5-jsend-transformer/issues/new)
 - Using Gitter: [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/nilportugues/laravel5-jsend-transformer?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)


<br>
## Authors

* [Nil Portugués Calderó](http://nilportugues.com)
* [The Community Contributors](https://github.com/nilportugues/laravel5-jsend-transformer/graphs/contributors)


## License
The code base is licensed under the [MIT license](LICENSE).
