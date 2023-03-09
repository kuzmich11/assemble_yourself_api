# Авторизация и аутентификация

_Во всех запросах должен присутствовать header_

[

    Key: "X-Requested-With"

    Value: "XMLHttpRequest"

]


## Регистрация

### Точка Входа

- Точка входа для регистрации: **/api/register**

### Запрос

- Метод: **POST**

- Схема:

  {

  **name: string**

  **email: string**

  **password: string**

  }

### Ответ

#### Успех

- Схема:

  {

  "message": "Success"

  }
  - Код ответа: 200

- Cookies

        [
    
        name: 'token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

#### Неудача

Вариант 1 (если пользователь с данным email уже существует).

- Схема:

  {

  "error": true,

  "message": "Пользователь с данным email уже существует"

  }

- Код ответа: 400

Вариант 2 (любые другие причины)

- Схема:

  {

  "error": true,

  "message": "Не удалось зарегистрировать пользователя"

  }

- Код ответа: 400


## Авторизация

### Точка Входа

- Точка входа для регистрации: **/api/login**

### Запрос

- Метод: **POST**

- Схема:

  {

  **email: string**

  **password: string**

  }

### Ответ

#### Успех

- Схема:

  {

  "message": "Success"

  }
- Код ответа: 200
- Cookies

        [
    
        name: 'token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

#### Неудача

- Схема:

  {

  "error": "Unauthorized"

  }

- Код ответа: 401


## Получение пользователя по токену

### Точка Входа

- Точка входа для регистрации: **/api/me**

### Запрос

- Метод: **POST**

- BearerToken "token"

### Ответ

#### Успех

- Схема:

  {

  "id": 1,

  "name": "user",

  "email": "test@test.ru",

  "created_at": "2023-03-07T18:46:57.000000Z",

  "updated_at": "2023-03-07T18:46:57.000000Z"

  }
- Код ответа: 200

#### Неудача

- Схема:

  {

  "message": "Unauthenticated."

  }

- Код ответа: 401

## Обновление токена

### Точка Входа

- Точка входа для регистрации: **/api/refresh**

### Запрос

- Метод: **POST**

- BearerToken "token"

### Ответ

#### Успех

- Схема:

  {

  "message": "Success"

  }
- Код ответа: 200

- Cookies

        [

        name: 'token'

        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

#### Неудача

- Схема:

  {

  "message": "The token has been blacklisted"

    ...

  }

- Код ответа: 500


## Выход

### Точка Входа

- Точка входа для регистрации: **/api/logout**

### Запрос

- Метод: **POST**

### Ответ

#### Успех

- Схема:

  {

  "message": "Successfully logged out"

  }
- Код ответа: 200


#### Неудача

- Схема:

  {

  "message": "Unauthenticated."

  }

- Код ответа: 401


# Курсы

## Список всех курсов

### Точка Входа

- Точка входа для регистрации: **/api/courses**

### Запрос

- Метод: **GET**

### Ответ

#### Успех

- Схема:

  {

  "id": 1,

  "course_name": "Psychiatrist",

  "author": "Dr. Alford Stiedemann MD",

  "price": "476",

  "created_at": "2023-03-02T16:39:18.000000Z",

  "updated_at": "2023-03-02T16:39:18.000000Z"

  }, ...

- Код ответа: 200

Если в базе нет записей курсов, то вернется пустой json с кодом 200.

#### Неудача

(Только в случае если база не доступна)

- Код ответа: 500


## Страница нужного курса

### Точка Входа

- Точка входа для регистрации: **/api/courses/{id}**

### Запрос

- Метод: **GET**

### Ответ

#### Успех

- Схема:

  {

  "id": 1,

  "course_name": "Psychiatrist",

  "author": "Dr. Alford Stiedemann MD",

  "price": "476",

  "created_at": "2023-03-02T16:39:18.000000Z",

  "updated_at": "2023-03-02T16:39:18.000000Z"

  }
- Код ответа: 200

#### Неудача

- Схема:

  {

  "message": "Такого курса не существует"

  }

- Код ответа: 404

В случае если база не доступна

- Код ответа: 500
