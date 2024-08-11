Notice: All files / modules dependent on [Composer](https://getcomposer.org/).

## Installing
```bash
~$ mkdir -p /path/to/chat-box ; cd /path/to/chat-box \
   ; git clone git@github.com:froq/chat-box.git . \
   ; rm -rf .git/ ; composer install
```

## Running
After running the command below, you can test all endpoints with Postman or similar tool through this base URL [http://localhost:8000/](http://localhost:8000/).
```bash
~$ php -S localhost:8000 bin/server.php
```

## Testing
```bash
~$ vendor/bin/phpunit --bootstrap=./boot.php ./ --colors --testdox
```

## RESTful API / Endpoints
All endpoints work with JSON payloads.

### `POST /api/purchase`
Place a new subscription purchase for a device.

#### Body Parameters
| Name | Type | Default | Description |
| -    | -    | -       | -           |
| device_uuid | String | - | Device UUID. |
| device_name | String | - | Device name. |

#### Request
```json
{
  "device_uuid": "66b8baa6-7405-4d42-b950-ac2a39cf7196",
  "device_name": "Android"
}
```

#### Response
```json
{
  "status": 200,
  "data": {
    "id": 4,
    "device_uuid": "66b8baa6-7405-4d42-b950-ac2a39cf7196",
    "device_name": "Android",
    "access_token": "5UZF1ATg2tY0HsE0DFhCS9yptlBBHS4bxri8yWrPY6fVkXDOhrWMIwDHVIGX7QzwOg6ZWCdDISobkPqny3wPRSBepDYuBCeRzhMwogYZGHxIlhslWcFfszeeKRlAVYYs1P4Qm4NGAovE",
    "status": "premium",
    "credit": 100,
    "created_at": "2024-08-11T22:02:43+00:00",
    "updated_at": null
  },
  "error": null
}
```

#### Errors
`400 Bad Request`: If no valid `device_uuid` or `device_name` provided.

### `POST /api/auth`
Get an authorization details.

#### Body Parameters
| Name | Type | Default | Description |
| -    | -    | -       | -           |
| device_uuid | String | - | Device UUID. |
| device_name | String | - | Device name. |

#### Request
```json
{
  "device_uuid": "66b8baa6-7405-4d42-b950-ac2a39cf7196",
  "device_name": "Android"
}
```

#### Response
```json
{
  "status": 200,
  "data": {
    "device_uuid": "66b8baa6-7405-4d42-b950-ac2a39cf7196",
    "device_name": "Android",
    "access_token": "5UZF1ATg2tY0HsE0DFhCS9yptlBBHS4bxri8yWrPY6fVkXDOhrWMIwDHVIGX7QzwOg6ZWCdDISobkPqny3wPRSBepDYuBCeRzhMwogYZGHxIlhslWcFfszeeKRlAVYYs1P4Qm4NGAovE",
    "status": "premium",
    "credit": 100
  },
  "error": null
}
```

#### Errors
`404 Not Found`: If no authorization found with provided `device_uuid` or `device_name`.

### `POST /api/subscription`
Get a subscription details.

#### Header Parameters
| Name | Type | Default | Description |
| -    | -    | -       | -           |
| Authorization | String | - | From `/api/auth` (`data.access_token`). |

#### Request
```json
{}
```

#### Response
```json
{
  "status": 200,
  "data": {
    "id": 1,
    "status": "premium",
    "credit": 100
  },
  "error": null
}
```

#### Errors
`400 Bad Request`: If no valid authorization provided. <br>
`404 Not Found`: If no subscription found with provided authorization.

### `POST /api/chat`
Start or continue a chat.

#### Header Parameters
| Name | Type | Default | Description |
| -    | -    | -       | -           |
| Authorization | String | - | From `/api/auth` (`data.access_token`). |

#### Body Parameters
| Name | Type | Default | Description |
| -    | -    | -       | -           |
| chat_id | String? | - | From `/api/chat` (`data.id`), to continue with the same chat. |
| message | String | - | Chat message. |

#### Requests
```json
{
  "chat_id": null,
  "message": "Test."
}

{
  "chat_id": 1,
  "message": "Test again."
}
```

#### Responses
```json
{
  "status": 200,
  "data": {
    "id": 1,
    "pid": null,
    "response": "Lorem ipsum dolor.",
    "subscription": {
      "id": 1,
      "status": "premium",
      "credit": 99
    }
  },
  "error": null
}

{
  "status": 200,
  "data": {
    "id": 2,
    "pid": 1,
    "response": "Sit amet etiam in diam ex.",
    "subscription": {
      "id": 1,
      "status": "premium",
      "credit": 98
    }
  },
  "error": null
}
```

#### Errors
`400 Bad Request`: If no valid authorization provided. <br>
`401 Unauthorized`: If no valid subscription found with provided authorization. <br>
`401 Payment Required`: If subscription credits lower than 0 (each chat lowers it by -1).
