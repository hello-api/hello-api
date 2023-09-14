<?php

/**
 * @apiDefine GeneralSuccessMultipleResponse
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data": [
 * {
 * // same object structure of the single response
 * },
 * {
 * // ...
 * },
 * // ...
 * ],
 * "include": [
 * "xxx",
 * "yyy",
 * ],
 * "custom": [],
 * "meta": {
 * "pagination": {
 * "total": x,
 * "count": x,
 * "per_page": x,
 * "current_page": x,
 * "total_pages": x,
 * "links": []
 * }
 * }
 * }
 */
