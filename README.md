# About
This is Wordpress theme boilerplate. I use it for fast build new themes. It stores some code parts but you will need to review and setup templates for your needs.

For use it:
- get [wordpress](https://ru.wordpress.org/) and setup it
- create empty folder for your theme
- clone in it this project
- setup project and frontend build 

## Helpful plugins:
- ACF - for custom fields
- Polylang - for multilanguage
- Loco Translate - for translate custom strings, plugins etc
- FileBird - for media files organize
- SVG Support
- W3 Total Cache 
- Webcraftic Cyr to Lat reloaded - auto change cyr chars to lat

## Project structure
- **assets** - generic folder from fronted, dont touch it
- **favicon** - folder with favicons. I use [favicon-generator.org](https://www.favicon-generator.org/) for generate it, you can choose any other. Just generate and replace on your own.
- **frontend** - files for develop and build frontend part (scripts, styles etc)
- **funcs** - store splitted on parts functions.php
- **inc** - global modules for include in different templates, like language switcher, modals etc

## Need to review and setup
Please review `.php` files, especially this:
- `style.css` - dont forget to put your own info
- `functions.php` - review existing functions and comment/remove for your needs. I split functions on big parts and place it in `funcs` folder in theme root
- `inc/logo.php` - template for your logo. Set link to your site logo
- `inc/modals` - here is store modals templates. I use [MicroModal](https://micromodal.now.sh/) for setup modals
- `inc/svg-defs.php` - i use this as svg _spritesheet_

## Frontend
Setup and review `webpack_configs/common.js` - especially settings for proxy, js files.
All assets that you will need for work in most cases stored in `src` folder.
Styles included from one file - `index.scss`

### For local development
- Move to frontend folder.
- Use `npm install` or `yarn` for download project dependencies
- Type in `webpack_configs/common.js` proxy for local site `const SITE_PROXY = 'http://invest.local';` 
_*your local site url_

Use command `npm run dev` or `yarn dev` for run dev server
Use command `npm run build` or `yarn build` for build frontend. Builded files will be stored in assets folder, in theme root

### Dev dependencies that you may not need
- aos - for effects on scroll
- slick-carousel - popular slider, need jquery
- jquery - if you will not need it, remove it from webpack common config and php funcs/assets