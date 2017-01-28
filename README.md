[![XO code style](https://img.shields.io/badge/code_style-XO-5ed9c7.svg)](https://github.com/sindresorhus/xo)

# Aleph

`Aleph` is an opinionated starter theme with a modern development workflow. Partially based on [_s](https://github.com/Automattic/_s), `Aleph` is designed to make the life of WordPress developers easier.

## Features

* [BEM](http://getbem.com/) syntax (when possible)
* Modular Sass files
* Ready to use `package.json` file (npm as a build tool)
	* Lint ([XO](https://github.com/sindresorhus/xo)) and minimize ([UglifyJS 2](https://github.com/mishoo/UglifyJS2)) your Javascript files
	* Compile your Sass files with [node-sass](https://github.com/sass/node-sass)
	* Optimize your compiled CSS files with [PostCSS](http://postcss.org/): [Autoprefixer](https://github.com/postcss/autoprefixer) and [CSS MQPacker](https://github.com/hail2u/node-css-mqpacker) are already included
	* Generate a `pot` file with [wp-pot-cli](https://github.com/rasmusbe/wp-pot-cli)
	* Optionally sync your theme folder with your server or VM
	* Generate a zip file containing the production files
* [Browsersync](https://browsersync.io/) for synchronized browser testing
* [Kirki](https://aristath.github.io/kirki/) toolkit to abstract the WordPress Customizer API

## Requirements

Make sure all dependencies have been installed before moving on:

* [Node.js](http://nodejs.org/)
* [postcss-cli](https://github.com/postcss/postcss-cli)
* [wp-pot-cli](https://github.com/rasmusbe/wp-pot-cli)

## Getting started

Download `Aleph` from GitHub and rename the folder to something else (like `your-theme-name`). Then find (case sensitive) and replace the following strings in the **PHP files** (in this order):

1. Search for: `'aleph'` (inside single quotations) and replace with: `'your-theme-name'`. This is the text domain.
2. Search for: `aleph_` and replace with: `your_theme_name_`. This is the prefix used in all function names.
3. Search for: <code>&nbsp;Aleph</code> (note the space before <code>&nbsp;Aleph</code>) and replace with: <code>&nbsp;Your_Theme_Name</code>. This captures the theme name in DocBlocks.
4. Search for: `Aleph_` and replace with: `Your_Theme_Name_`. This is the prefix used in all class names.
5. Search for: `aleph-` and replace with: `your-theme-name-`. This is the handle prefix of the theme's scripts.

Then, update the stylesheet header in `style.css` and in `sass/style.scss`.

Now, you have two possibilities: move your theme folder in `wp-content/themes` as usual or use npm to sync your theme folder with your WordPress installation located in another server or VM. It's up to you. Personally, I have a `wp` folder in my computer with all my theme folders inside. And all of them are uploaded (and synchronized) to my local server trough npm when I make a change. More info in the next section if you're interested.

## Npm usage

`Aleph` comes with a ready to use `package.json` file that allows you to run and watch some powerful tasks. You can compile your Sass files, minimize your scripts, preview your changes and so on.

The first thing you need to do is install the npm dependencies. So, with the terminal cd into your theme folder and run `npm install`. Remember that you also need [postcss-cli](https://github.com/postcss/postcss-cli) and [wp-pot-cli](https://github.com/rasmusbe/wp-pot-cli) installed globally. More info in the respective project pages but basically, you just need to run this command in your terminal to install them:

```bash
npm install postcss-cli wp-pot-cli -g
```

To make your life easier, `Aleph` uses a `.npmrc` (not included in this repo) to pass the project configuration values. So, create a `.npmrc` file in the root of your theme folder and adjust the following settings:

```bash
ALEPH_SLUG='your-theme-name'
ALEPH_NICENAME='Your Theme Name'
ALEPH_POT_BUG_REPORT='https://your-website-here'
ALEPH_POT_TEAM='Your Name <info@example.com>'
ALEPH_URL='http://path-to-your-wordpress-installation'
ALEPH_SSHPORT='22'
ALEPH_SYNCDEST='username@hostname:path'
```

Settings in detail:

* `ALEPH_SLUG`: the slug of your theme
* `ALEPH_NICENAME`: the name of your theme
* `ALEPH_POT_BUG_REPORT`: the URL for reporting translation bugs
* `ALEPH_POT_TEAM`: name and email address of the translation team
* `ALEPH_URL`: proxy URL to view your site; more info [here](https://browsersync.io/docs/options#option-proxy)
* `ALEPH_SSHPORT`: SSH port
* `ALEPH_SYNCDEST`: rsync destination; for example `username@hostname:/var/www/html/wordpress/wp-content/themes/your-theme-name`

You don't need to specify all those settings. `ALEPH_SSHPORT` and `ALEPH_SYNCDEST` are required only by the *sync* task. And `ALEPH_URL` by Browsersync.

## Tasks included

There are five tasks you can run during the development of your theme. And four of them (`build`, `build-sync`, `build-server` and `build-sync-server`) watch for changes.

### build

With this task you can compile your Sass files, optimize the compiled CSS files, lint and minimize the Javascript files and generate the `pot` file of your theme. Just run this command in the terminal:

```bash
npm run build
```

### build-sync

Same as the build task plus the possibility to sync your theme folder with another folder in a different server or VM. You need to specify a correct destination and SSH port in the `.npmrc` file: `ALEPH_SYNCDEST` and `ALEPH_SSHPORT`.

Run this command in the terminal:

```bash
npm run build-sync
```

### build-server

Same as the build task plus the possibility to sync your site across multiple devices with Browsersync. You need to specify a correct proxy URL in the `.npmrc` file: `ALEPH_URL`.

Run this command in the terminal:

```bash
npm run build-server
```

### build-sync-server

All the previous three tasks together.

Run this command in the terminal:

```bash
npm run build-sync-server
```

### zip

Run this command to create a zip file containing the production files:

```bash
npm run zip
```

That's all, now make a great theme :)
