# WordPress development en fuego

Local WordPress development environment with all the bells and whistles. Give this
repo a try if you

1. Develop multiple themes/plugins for [WordPress](http://wordpress.org/)
2. Your target sites' image assets won't fit in your local machine
3. Want to keep your development environment clean and portable
4. Are a badass

## Prerequisites & Installation

Ensure you have [Docker
Toolbox](https://www.docker.com/products/docker-toolbox) installed (Mac OSX) or
that you have both `docker-machine` and `docker-compose` installed (Linux).
Also, ensure that your default `docker-machine` is up and running.

[Composer](https://getcomposer.org/) is used manage your themes/plugins.
Install it following the instructions for your OS.

Configure all the themes and plugins you'd like to have in your WordPress
installation in `composer.json`. Take a look at the [WordPress
Packagist](https://wpackagist.org/) page for information. By default, 
Askimet is installed.

After you're happy with your set up, issue from the command line

```sh
$ composer install
```

(You may need to replace `composer` with whichever path/command that applies to
your system)

The command pulls in all the plugins/themes and copies them to the `wp-content`
directory. It also starts the Docker build process and creates the WordPress
image for you. This may take several minutes. The build process installs
various PHP extensions, memcached and WP CLI among other tools. NB: these are
installed in the container, not your machine.

If all went ok, you're now ready to launch your WordPress container. Edit the
`docker-compose.yml` file in the repository root and create a Docker compose
service for your WordPress installation; an example is provided.

```
mysite:
  extends:
    file: ./docker/docker-compose.yml
    service: wordpress
  links:
    - db:mysql
  environment:
    WP_LOCAL_DOMAIN: mysite.dev
    WP_ASSETS_DOMAIN: mysite.com

```

The two environment variables are mandatory. The first one defines the domain
for your WordPress installation, while the other is used to grab image assets
so you do not have to host them locally on your machine.

You can have any number of these services, each corresponding to a site
you're developing; let us launch `mysite.dev`:

```sh
docker-compose up mysite
```

You should now see your local WordPress environment starting Apache inside the
container.

Congratulations! To navigate to your local site, set up a [host
definition](https://en.wikipedia.org/wiki/Hosts_(file)) in `/etc/hosts`.  

An example for `mysite.dev`:

```
# File /etc/hosts
192.168.99.100 mysite.dev
```

The IP address is that of my default docker machine. Check yours with
`docker-machine ip default`. 

Now, you can navigate to `http://mysite.dev` and log in as `admin`, password
`dummy`.

## How it works

1. The WordPress installations are linked with a common MySQL container that
   holds all the databases, one for each installation.
    * The database creation is fully automated. 
    * The MySQL service is exposed on port 8889 on your local machine. Login as
     `root`, password `dummy`.
    * You may want to import posts from some WP installations into your local environment, but please
      don't export this dummy databases into production

2. WordPress core is installed into the image, the wp-content directory is mounted
   from your local machine
    * You may always drag and drop stuff into the wp-content directory and it will appear
      in the Docker container
    * wp-config.php is also mounted but you don't need to touch this file unless you want to 
      do something special.

3. Apache redirects all requests to image assets to an online WordPress installation
    * Control the target domain with the WP_ASSETS_DOMAIN environment variable.

## FAQ

- I'm on Linux and it does not work!?

  * I have notices that SELinux messes with Docker, preventing
    Docker to mount files into containers.
  * See [this](http://www.projectatomic.io/docs/docker-and-selinux/) tutorial for pointers 

- I do not have a target domain, I want to have a local uploads directory with kitten pictures
  * I welcome patches

- But I develop my own theme/plugin. I cannot get it thru composer.
  * No problem. Just drop your projects in wp-content and they will be
   available in the WordPress container.
  * You may even consider setting up a private Packagist repo for your organization. That way you
    can pull in all the themes/plugins along with the public ones with composer. 

## Tips
- If you're on Mac OSX, give [Gas Mask](https://github.com/2ndalpha/gasmask) a try.

