ZF2 Adv. demo
=======================

This is simple example of management books in library, with UI (twitter bootstrap) and API.

ZF2 advanced structure:
- single action per controller (easy to manage, easy to test)
- DI, SOLID

API:
/api/library/books[/:id]

Filtering, ordering, limiting:
/api/library/books?year=2004,2008,2011&sort=-year&limit=2&offset=1

TODO
-----------------------
1. ~~write the rest of tests~~
2. ~~implement logs~~
3. implement cache
4. ~~implement authorization~~
5. implement acl
6. implement admin panel
7. transfer updating/creating/deleting privileges of books to administrator
8. ~~implement query filtering in API with limit, offset, sort options~~

