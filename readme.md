Craigslist REST API
===================

The purpose of this API is to query data from [Craigslist] [craigslist] so that developers can use them in their app. The API itself is written with [Laravel] [laravel] PHP framework.

Demo
----
For user guide and demo, visit [craigslist.demoz.co][demo].

Usage
-----

Send a `GET` request to the resource as specified in the following format:

| Resource | Description |
-----------|-------------|
| `GET` `/api/{city}/{category}/{page}` | Get listing within a city by a specific category |

Example
-------

Let's get the first `100` job listing in `New York City` under `Web Design` category. This is simply done by sending a `GET` request to `/api/newyork/web/1`.

    GET /api/newyork/web/1

It will send a JSON response back which looks similar to this:
````json
[
  {
    "date": "Friday, October 18, 2013",
    "results": [
      {
        "url": "http:\/\/newyork.craigslist.org\/mnh\/web\/4137716940.html",
        "title": "Interactive Web Content Specialist",
        "location": "Midtown West"
      },
      {
        "url": "http:\/\/newyork.craigslist.org\/mnh\/web\/4137682225.html",
        "title": "Freelance Web Project!",
        "location": "SoHo"
      },
      ...
      ...
  }
]
````

[craigslist]: http://www.craigslist.org/  "Craigslist"
[laravel]: http://laravel.com/  "Laravel PHP Framework"
[demo]: http://craigslist.demoz.co/ "Craigslist API Demo"