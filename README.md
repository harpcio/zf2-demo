ZF2 Adv. demo
=======================

This is simple example of management books in library, with UI (twitter bootstrap) and API.

ZF2 advanced structure:
- single action per controller (easy to manage, easy to test)
- DI, SOLID

API:
- /api/library/books[/:id]

Filtering:
- special commands:
    - $sort (ie: /api/library/books?$sort=-year,price) will sort by year [desc] and price [asc]
    - $limit (ie: /api/library/books?$limit=1)
    - $offset (ie: /api/library/books?$offset=1)
- criteria commands:
    - $between(x, y) (ie: /api/library/books?year=$between(1999,2014))
    - $startswith(x) (ie: /api/library/books?publisher=$startswith("o're"))
    - $endswith(x) (ie: /api/library/books?title=$endswith(sql))
    - $min(x) (ie: /api/library/books?price=$min(37.99))
    - $max(x) (ie: /api/library/books?price=$max(40.44))
- in array options:
    - ie: /api/library/books?year=2004,2008,2014

We can combine all commands:
- ie: /api/library/books?year=2004,2008,2014&$sort=-year&$limit=2&$offset=1

TODO
-----------------------
1. ~~write the rest of tests~~
2. ~~implement logs~~
3. implement cache
4. ~~implement authorization~~
5. implement acl
6. implement admin panel
7. transfer updating/creating/deleting privileges of books to administrator
8. ~~implement query filtering in API with multiple options and special commands~~

