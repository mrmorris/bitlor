# Readme

This is a bit.ly clone for a coding exercise. 

Run the server, then visig

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
