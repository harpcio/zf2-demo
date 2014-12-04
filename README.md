[![wercker status](https://app.wercker.com/status/f369e88718a1cbe522693eaad4c686f8/m "wercker status")](https://app.wercker.com/project/bykey/f369e88718a1cbe522693eaad4c686f8)
[![Build Status](https://travis-ci.org/harpcio/zf2-demo.svg?branch=master)](https://travis-ci.org/harpcio/zf2-demo)
[![Coverage Status](https://img.shields.io/coveralls/harpcio/zf2-demo.svg)](https://coveralls.io/r/harpcio/zf2-demo?branch=master)
ZF2 Advanced demo
=======================

This is example of management books in library, with UI (twitter bootstrap) and API.

ZF2 advanced structure:
- single action per controller (easy to manage, easy to test) complies with SOLID principles

API
-----------------------
- /api/library/books[/:id]

Filtering:
- special commands:
    - $fields (ie: /api/library/books?$fields=id,title,price)
    - $sort (ie: /api/library/books?$sort=-year,price) will sort by year [desc] and price [asc]
    - $limit (ie: /api/library/books?$limit=1)
    - $offset (ie: /api/library/books?$offset=1)
- criteria commands:
    - $between(x, y) (ie: /api/library/books?year=$between(1999,2014))
    - $startswith(x) (ie: /api/library/books?publisher=$startswith("o're"))
    - $endswith(x) (ie: /api/library/books?title=$endswith(sql))
    - $min(x) (ie: /api/library/books?price=$min(37.99))
    - $max(x) (ie: /api/library/books?price=$max(40.44))
- in array option:
    - ie: /api/library/books?year=2004,2008,2014
    - ie: /api/library/books?publisher=O'Reilly Media,Packt Publishing
- equal option:
    - ie: /api/library/books?title="Software, Development"
- two options on the same column
    - ie: /api/library/books?title[]=$startswith("clean")&title[]=$endswith("ship")

We can also combine all commands:
- ie: /api/library/books?year=$between(2000,2014)&price[]=$min(32)&price[]=$max(40)&$sort=-year&$limit=2&$offset=1

We can also do this on books list:
- ie. /library/books?year=$between(2000,2014)&price[]=$min(32)&price[]=$max(40)&$sort=-year&$limit=2&$offset=1

ACL
-----------------------
With the new structure (Single Action Per Controller) we have also the possibility 
to restrict access for API by user (ie. CREATE, PUT, DELETE only for admin).

Installation
------------

Using Composer (recommended)
----------------------------
Clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/project/dir
    git clone --depth=1 git://github.com/harpcio/zf2-demo.git
    cd zf2-demo
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Web Server Setup
----------------

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName local.zf2-demo
        DocumentRoot /path/to/zf2-demo/public
        SetEnv APPLICATION_ENV "development"                #remove this on production
        <Directory /path/to/zf2-demo/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

TODO
-----------------------
1. ~~write the rest of tests~~
2. ~~implement logs~~
3. ~~implement cache (doctrine: [proxy, metadata, query, result], zf2 [app-config, module-map])~~
4. ~~implement authorization~~
5. ~~implement acl~~
6. implement admin panel
7. ~~transfer updating/creating/deleting privileges of books to administrator~~
8. ~~implement query filtering in API with multiple options and special commands~~
9. ~~implement navigation with acl filtering~~
10. pagination, sorting, filtering on lists

