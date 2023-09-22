## **Usage Overview**

Here are some information that should help you understand the basic usage of our RESTful API. 
Including info about authenticating users, making requests, responses, potential errors, rate limiting, pagination, query parameters and more.

## **Headers**

Certain API calls require you to send data in a particular format as part of the API call. 
By default, all API calls expect input in `JSON` format, however you need to inform the server that you are sending a JSON-formatted payload.
And to do that you must include the `Accept => application/json` HTTP header with every call.


| Header        | Value Sample                        | When to send it                                                              |
|---------------|-------------------------------------|------------------------------------------------------------------------------|
| Accept        | `application/json`                  | MUST be sent with every endpoint.                                            |
| Content-Type  | `application/x-www-form-urlencoded` | MUST be sent when passing Data.                                              |
| Authorization | `Bearer {Access-Token-Here}`        | MUST be sent whenever the endpoint requires (Authenticated User).            |

## **Rate limiting**

All REST API requests are throttled to prevent abuse and ensure stability. 
The exact number of calls that your application can make per day varies based on the type of request you are making.

The rate limit window is `{{rate-limit-expires}}` minutes per endpoint, with most individual calls allowing for `{{rate-limit-attempts}}` requests in each window.

*In other words, each user is allowed to make `{{rate-limit-attempts}}` calls per endpoint every `{{rate-limit-expires}}` minutes. (For each unique access token).*

For how many hits you can preform on an endpoint, you can always check the header:

```
X-RateLimit-Limit → 30
X-RateLimit-Remaining → 29
```

## **Tokens**

The Access Token lives for `{{access-token-expires-in}}`. (equivalent to `{{access-token-expires-in-minutes}}` minutes).
While the Refresh Token lives for `{{refresh-token-expires-in}}`. (equivalent to `{{refresh-token-expires-in-minutes}}` minutes).

*You will need to re-authenticate the user when the token expires.*

## **Pagination**

By default, all fetch requests return the first `{{pagination-limit}}` items in the list. Check the **Query Parameters** for how to control the pagination.

## **Limit:** 

The `?limit=` parameter can be applied to define, how many record should be returned by the endpoint (see also `Pagination`!).

**Usage:**

```
api.domain.test/v1/endpoint?limit=100
```

The above example returns 100 resources. 

The `limit` and `page` query parameters can be combined in order to get the next 100 resources:

```
api.domain.test/v1/endpoint?limit=100&page=2
```

You can skip the pagination limit to get all the data, by adding `?limit=0`, this will only work if 'skip pagination' is enabled on the server.

## **Responses**

Unless otherwise specified, all of API endpoints will return the information that you request in the JSON data format.


#### Standard Response Format

```json
{
  "data": {
    "object": "Role",
    "id": "owpmaymq",
    "name": "admin",
    "description": "Administrator",
    "display_name": null,
    "permissions": {
      "data": [
        {
          "object": "Permission",
          "id": "wkxmdazl",
          "name": "update-users",
          "description": "Update a User.",
          "display_name": null
        },
        {
          "object": "Permission",
          "id": "qrvzpjzb",
          "name": "delete-users",
          "description": "Delete a User.",
          "display_name": null
        }
      ]
    }
  }
}
```

#### Header

Header Response:

```
Content-Type → application/json
Date → Thu, 14 Feb 2014 22:33:55 GMT
ETag → "9c83bf4cf0d09c34782572727281b85879dd4ff6"
Server → nginx
Transfer-Encoding → chunked
X-Powered-By → PHP/7.0.9
X-RateLimit-Limit → 100
X-RateLimit-Remaining → 99
```

## **Query Parameters**

Query parameters are optional, you can apply them to some endpoints whenever you need them.

### Ordering

The `?orderBy=` parameter can be applied to any **`GET`** HTTP request responsible for ordering the listing of the records by a field.

**Usage:**

```
api.domain.test/v1/endpoint?orderBy=created_at
```

### Sorting

The `?sortedBy=` parameter is usually used with the `orderBy` parameter.

By default the `orderBy` sorts the data in **ascending** order, if you want the data sorted in **descending** order, you can add `&sortedBy=desc`.

**Usage:**

```
api.domain.test/v1/endpoint?orderBy=name&sortedBy=desc
```

Order By Accepts:

- `asc` for Ascending.
- `desc` for Descending.

### Searching

If the [RequestCriteria](http://apiato.io/docs/core-features/query-parameters#using-the-request-criteria)
is enabled on a route then the `?search=` parameter can be applied to **`GET`** HTTP requests on that specific route.

**Usage:**

#### Search any field:

```
api.domain.test/v1/endpoint?search=keyword here
```

> Space should be replaced with `%20` (search=keyword%20here).

#### Search any field for multiple keywords:

```
api.domain.test/v1/endpoint?search=first keyword;second keyword
```

#### Search in a specific field:
```
api.domain.test/v1/endpoint?search=field:keyword here
```

#### Search in specific fields for multiple keywords: 
```
api.domain.test/v1/endpoint?search=field1:first field keyword;field2:second field keyword
```

#### Define query condition:

```
api.domain.test/v1/endpoint?search=field:keyword&searchFields=name:like
```

Available Conditions: 

- `like`: string like the field. (SQL query `%keyword%`).
- `=`: string exact match.


#### Define query condition for multiple fields:

```
api.domain.test/v1/endpoint?search=field1:first keyword;field2:second keyword&searchFields=field1:like;field2:=;
```

#### Search Join:
By default, search makes its queries using the OR comparison operator for each query parameter.

```
api.domain.test/v1/endpoint?search=age:17;email:john@gmail.com
```

The above example will execute the following query:

```sql
SELECT * FROM users WHERE age = 17 OR email = 'john@gmail.com';
```
In order for it to query using the AND, pass the `searchJoin` parameter as shown below:

```
api.domain.test/v1/endpoint?search=age:17;email:john@gmail.com&searchJoin=and
```

### Filtering

The `?filter=` parameter can be applied to any HTTP request. And is used to control the response size, by defining what data you want back in the response.

**Usage:**

Return only ID and Status from the Model.

```
api.domain.test/v1/endpoint?filter=id;status
```

Example Response, including only id and status:

```json
{
  "data": [
    {
      "id": "0one37vjk49rp5ym",
      "status": "approved",
      "products": {
        "data": [
          {
            "id": "bmo7y84xpgeza06k",
            "status": "pending"
          },
          {
            "id": "o0wzxbg0q4k7jp9d",
            "status": "fulfilled"
          }
        ]
      },
      "recipients": {
        "data": [
          {
            "id": "r6lbekg8rv5ozyad"
          }
        ]
      },
      "store": {
        "data": {
          "id": "r6lbekg8rv5ozyad"
        }
      }
    }
  ]
}
```


### Paginating

The `?page=` parameter can be applied to any **`GET`** HTTP request responsible for listing records (mainly for Paginated data).

**Usage:**

```
api.domain.test/v1/endpoint?page=200
```

*The pagination object is always returned in the **meta** when pagination is available on the endpoint.*

```json
  "data": [...],
  "meta": {
    "pagination": {
      "total": 2000,
      "count": 30,
      "per_page": 30,
      "current_page": 22,
      "total_pages": 1111,
      "links": {
        "previous": "http://api.domain.test/v1/endpoint?page=21"
      }
    }
  }
```

### Relationships

The `?include=` parameter can be used with any endpoint, only if it supports it. 

How to use it: let's say there's a Driver object and Car object. And there's an endpoint `/cars` that returns all the cars objects. 
The include allows getting the cars with their drivers `/cars?include=drivers`. 

However, for this parameter to work, the endpoint `/cars` should clearly define that it
accepts `driver` as relationship (in the **Available Relationships** section).

**Usage:**

```
api.domain.test/v1/endpoint?include=relationship
```

Every response contains an `include` in its `meta`  as follow:

```
   "meta":{
      "include":[
         "relationship-1",
         "relationship-2",
      ],
```


### Caching

Some endpoints store their response data in memory (caching) after querying them for the first time, to speed up the response time.
The `?skipCache=` parameter can be used to force skip loading the response data from the server cache and instead get a fresh data from the database upon the request.

**Usage:**

```
api.domain.test/v1/endpoint?skipCache=true
```

## **Requests**

Calling unprotected endpoint example:

```shell
curl -X POST -H "Accept: application/json" -H "Content-Type: application/x-www-form-urlencoded; -F "email=admin@admin.com" -F "password=admin" -F "=" "http://api.domain.test/v2/register"
```

Calling protected endpoint (passing Bearer Token) example:

```shell
curl -X GET -H "Accept: application/json" -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." -H "http://api.domain.test/v1/users"
```

