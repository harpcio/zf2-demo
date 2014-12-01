[![Build Status](https://travis-ci.org/harpcio/zf2-demo.svg?branch=master)](https://travis-ci.org/harpcio/zf2-demo)
[![Coverage Status](https://img.shields.io/coveralls/harpcio/zf2-demo.svg)](https://coveralls.io/r/harpcio/zf2-demo?branch=master)
ZF2 Advanced demo
=======================

This is simple example of management books in library, with UI (twitter bootstrap) and API.

ZF2 advanced structure:
- single action per controller (easy to manage, easy to test) complies with SOLID principles

API
-----------------------
- /api/library/books[/:id] (POST, GET, PUT, DELETE)

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

ACL
-----------------------
With the new structure (Single Action Per Controller) we have also the possibility to restrict access in API (CREATE, PUT, DELETE).

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
9. implement navigation with acl filtering

