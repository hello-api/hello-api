## **Обзор**

Вот некоторая информация, которая должна помочь вам понять основы использования нашего RESTful API. Включая информацию об аутентификации пользователей, выполнении запросов, ответов,
потенциальных ошибках, ограничении скорости, нумерации страниц, параметрах запроса и многом другом.

## **Заголовки**

Некоторые вызовы API требуют, чтобы вы отправляли данные в определенном формате.
По умолчанию все вызовы API ожидают ввода в JSONформате, однако вам необходимо сообщить серверу,
что вы ожидаете полезную нагрузку в формате JSON. 
А для этого вы должны включать Accept => application/json HTTP-заголовок при каждом вызове.


| Заголовок     | Образенц значения                   | Когда отправлять                                                   |
|---------------|-------------------------------------|--------------------------------------------------------------------|
| Accept        | `application/json`                  | ДОЛЖЕН быть в КАЖДОМ запросе                                       |
| Content-Type  | `application/x-www-form-urlencoded` | ДОЛЖЕН быть отправлен при передаче данных                          |
| Authorization | `Bearer {Access-Token-Here}`        | ДОЛЖЕН быть отправлен всякий раз, когда запрос требует авторизации |

## **Rate limiting**

Все запросы REST API регулируются для предотвращения злоупотреблений и обеспечения стабильности. 
Точное количество вызовов, которое ваше приложение может совершать в день, зависит от типа отправляемого вами запроса.

Окно ограничения скорости составляет `{{rate-limit-expires}}` минут на endpoint, при этом большинство отдельных вызовов допускают `{{rate-limit-attempts}}` запросов в каждом окне.

*Другими словами, каждому пользователю разрешено совершать `{{rate-limit-attempts}}` вызовов на endpoint каждые `{{rate-limit-expires}}` минут. (Для каждого уникального токена доступа).*

Сколько запросов вы можете выполнить на endpoint, вы всегда можете проверить в заголовке:

```
X-RateLimit-Limit → 30
X-RateLimit-Remaining → 29
```

## **Tokens**

Токен доступа действителен `{{access-token-expires-in}}`. (`{{access-token-expires-in-minutes}}` минут).
Refresh Token действителен `{{refresh-token-expires-in}}`. (`{{refresh-token-expires-in-minutes}}` минут).

*Вам нужно будет повторно аутентифицировать пользователя, когда срок действия токена истечет.*

## **Pagination**

По умолчанию, все запросы с пагинацией возвращают первые `{{pagination-limit}}` элементов в списке. Прочтите раздел **Query Parameters**, чтобы узнать, как управлять нумерацией страниц.



## **Limit:** 

Параметр `?limit=`  может быть применен для указания сколько записей должно быть возвращено в ответе (Прочтите раздел `Pagination`!).

**Использование:**

```
api.domain.test/v1/endpoint?limit=100
```

Приведенный выше пример возвращает 100 ресурсов.

Параметры запроса  `limit` и `page` можно комбинировать, чтобы получить следующие 100 ресурсов:

```
api.domain.test/v1/endpoint?limit=100&page=2
```

Вы можете отключить ограничение пагинацию, чтобы получить все данные, указав  `?limit=0`, это будет работать только в том случае, если на сервере включен параметр 'skip pagination'. 

## **Responses**

Если не указано иное, все конечные точки API будут возвращать запрашиваемую вами информацию в формате JSON.


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

Параметры запроса являются необязательными, вы можете применить их к некоторым конечным точкам, когда они вам понадобятся.

### Ordering

Параметр `?orderBy=` может применяться к любому **`GET`** HTTP запросу чтобы упорядочить список записей в ответе по полю.

**Использование:**

```
api.domain.test/v1/endpoint?orderBy=created_at
```

### Sorting

Параметр `?sortedBy=` обычно используется вместе с `orderBy`.

По умолчанию `orderBy` сортирует данные в порядке **возрастания** если вы хотите, чтобы данные сортировались в порядке **убывания**, вы можете добавить `&sortedBy=desc`.

**Использование:**

```
api.domain.test/v1/endpoint?orderBy=name&sortedBy=desc
```

Доступные параметры сортировки:

- `asc` для сортировки по Возрастанию.
- `desc` для сортировки по Убыванию.

### Поиск

Если [RequestCriteria](http://apiato.io/docs/core-features/query-parameters#using-the-request-criteria)
включен для маршрута, то `?search=` параметр может быть использован для этого **`GET`** HTTP запроса.

**Использование:**

#### Поиск по любому из полей:

```
api.domain.test/v1/endpoint?search=keyword here
```

> Пробел нужно заменить на спецсимвол `%20` (search=keyword%20here).

#### Поиск в любом поле по нескольким ключевым словам:

```
api.domain.test/v1/endpoint?search=first keyword;second keyword
```

#### Поиск по определённому полю:
```
api.domain.test/v1/endpoint?search=field:keyword here
```

#### Поиск в определенных полях по нескольким ключевым словам: 
```
api.domain.test/v1/endpoint?search=field1:first field keyword;field2:second field keyword
```

#### Условия запроса:

```
api.domain.test/v1/endpoint?search=field:keyword&searchFields=name:like
```

Доступные условия: 

- `like`: строка похожа на образец. (SQL query `%keyword%`).
- `=`: точное совпадение строки.


#### Определить условия запроса для нескольких полей:

```
api.domain.test/v1/endpoint?search=field1:first keyword;field2:second keyword&searchFields=field1:like;field2:=;
```

#### Комбинированный поиск:
По умолчанию, поиск выполняется используя оператор сравнения ИЛИ для каждого параметра запроса. 

```
api.domain.test/v1/endpoint?search=age:17;email:john@gmail.com
```

В приведенном выше примере будет выполнен следующий запрос:

```sql
SELECT * FROM users WHERE age = 17 OR email = 'john@gmail.com';
```
Чтобы он выполнял запрос с использованием И, передайте `searchJoin` параметр, как показано ниже:

```
api.domain.test/v1/endpoint?search=age:17;email:john@gmail.com&searchJoin=and
```

### Фильтрация

Параметр `?filter=` может применяться к любому HTTP-запросу. И используется для управления размером ответа, определяя, какие данные вы хотите включить в ответ. 

**Использование:**

Возвращает только ID и Status из модели.

```
api.domain.test/v1/endpoint?filter=id;status
```

Пример ответа, включающий только идентификатор и статус:

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


### Пагинация

Параметр `?page=` может быть применен к любому **`GET`** HTTP-запросу возвращающему много записей в ответе (в основном для разбивки на страницы).

**Использование:**

```
api.domain.test/v1/endpoint?page=200
```

*Объект пагинации всегда возвращается в объекте **meta** если разбиение на страницы доступно для эндпоинта.*

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

### Отношения

Параметр `?include=` может быть использован с любым поддерживаемым его эндпоинтом. 

Как использовать: допустим, есть объект Driver и объект Car. И есть эндпоинт `/cars` который возвращает все объекты cars.  
Параметр `?include=` позволяет получить автомобили с их водителями `/cars?include=drivers`. 

Однако для того, чтобы этот параметр работал, эндпоинт `/cars` должен чётко определить, что он принимает
`driver` в качестве отношения (отображается в `include` объекте ответа).

**Использование:**

```
api.domain.test/v1/endpoint?include=relationship
```

Каждый ответ содержит `include` в объекте `meta`:

```
   "meta":{
      "include":[
         "relationship-1",
         "relationship-2",
      ],
```


### Кэширование

Некоторые конечные точки сохраняют свои данные ответа в памяти (кэше) после первого запроса, чтобы ускорить время ответа.
Параметр `?skipCache=` можно использовать, чтобы принудительно пропустить загрузку данных ответа из кэша сервера и вместо этого получить свежие данные из базы данных по запросу.

**Использование:**

```
api.domain.test/v1/endpoint?skipCache=true
```

## **Requests**

Пример вызова эндпойнта без авторизации:

```shell
curl -X POST -H "Accept: application/json" -H "Content-Type: application/x-www-form-urlencoded; -F "email=admin@admin.com" -F "password=admin" -F "=" "http://api.domain.test/v2/register"
```

Пример вызова эндпойнта с авторизацией (передача Bearer Token):

```shell
curl -X GET -H "Accept: application/json" -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." -H "http://api.domain.test/v1/users"
```
