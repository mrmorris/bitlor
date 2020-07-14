# Readme

This is a bit.ly clone for a coding exercise. 

Run the server, then visit localhost:port (the service will tell you which port to go to).

# Tell me about how this is done

This was built using CakePHP as a quick proof of concept. With a time constraint in place, I chose to focus on overall implementation of the requirements rather than getting into UI behavior & flow. 

Here are the interesting bits:

There are db migrations good to go based on `config/Migrations` but you can also look at the initial sql here: `config/schema/initial.sql` to see the database structure initially intended.

`src/Model` contains our entity & table definitions. We have two entities, `Post` and `Link`. The table classes help set up some basic validation. This is also where I created two "behaviors" (in cakephp-land) to help add functionality onto our `Post` and `Link` entities -- think of these as decorators or traits for entities.

`src/Model/Behavior/SluggableBehavior` helps set a "slug" for a new `Link`. It's not very clever and could use improvements - such as preventing duplicates (for now it just errors out due to the database index) and smartly increasing the length of the slug as needed. 

`src/Model/Behavior/LinkReplacerBehavior` can inspect the contents of a field, in this case our `Post.body` field, and replace urls with `<a>` tags with our shortened `Link` slug urls. It is built to handle multiple urls in the body, as well as repeats and "same domains" repeating without clobbering other urls with the same domain in the same body. 

`src/Controller` has a posts controller which handles viewing a list of posts (`index()`) and adding new posts (`add()`). The links controller just handles `view()` which increments a counter and redirects the user to their destination. 

`src/templates` is where our view files live. I didn't have to touch much here, I did just a little layout cleanup. Primarily I customized:
`src/templates/Posts/index.php`, `src/templates/Posts/add.php` and and `src/templates/layout/default.php`.

# Possible next steps

The test framework is good to go! I would have gone TDD if I had a bit more time, instead I would write a few integration-ish tests to verify my post-add action and the behavior(s) work as expected on their "Happy Paths". 

The "slug generator" is rather dumb, we could improve that, as well as the "view count" incrementor. A quick change to a direct SQL increment would probably be better here as a first start.

Then I would optimize the front-end a bit. Are we using a front-end framework or just a style kit? Do we need a build pipeline (or not), do we want it to behave more like a SPA? Etc...


# Set up

```bash
composer install
```

Update your `app/app_local.php` with your local db configs.

Then run migrations:

```bash
bin/cake migrations migrate
```

# Start the server

```bash
bin/cake server
```

# Tests?

Sadly, no tests added...

```bash
bin/cake test
```

# Using the service/site

`GET /`

Lists all "posts", which accept a "body" of text.

`POST /posts/add`

Creates a "post"

`GET /links/view/{slug}`

Visiting a link by it's "slug" will redirect you to the link's destination.
